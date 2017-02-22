<?php

/**
* @package SiteSearch
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc search your site easily
* @uses
* @example
* @files
*/





class SiteSearch
{

    var $section_list;             // (array)
    var $search_dir_list;          // (array)
    var $excluded_dir_list;        // (array)
    var $documents_extension_list; // (array)
    var $images_extension_list;    // (array)
    var $results_per_page;         // (int)
    var $minimun_word_size;        // (int)

    var $search_in_docs;           // (bool)
    var $search_in_imgs;           // (bool)
    var $exact_search;             // (bool)
    var $show_details;             // (bool)

    var $search;                   // (string)
    var $total_searched;           // (int)
    var $total_found;              // (int)
    var $search_time;              // (float)
    var $search_pattern;           // (string)
    var $extension_pattern;        // (string)

    var $error_message;            // (string)

    var $powerthumb_file;          // (string) Path to PowerThumb class file
    var $thumb;                    // (mixed)  It is an "object" if PowerThumb class exists. If not, is "false"


    function SiteSearch($section_list = array(),
                         $excluded_dir_list = array(),
                         $documents_extension_list = array("htm", "html", "shtml", "php", "php3", "jsp", "asp", "pdf", "txt"),
                         $images_extension_list = array("jpg", "jpeg", "gif", "png", "bmp")
                         )
    {

        $this->section_list             = (array)$section_list;
        $this->search_dir_list          = array();
        $this->excluded_dir_list        = (array)$excluded_dir_list;
        $this->documents_extension_list = (array)$documents_extension_list;
        $this->images_extension_list    = (array)$images_extension_list;
        $this->results_per_page         = 10;
        $this->minimun_word_size        = 3;


        $this->search_in_docs = true;
        $this->search_in_imgs = false;
        $this->show_details   = true;
        $this->exact_search   = (isset($_GET['exact_search'])  &&  $_GET['exact_search'] == 'yes')  ?  true  :  false;


        $this->search            = (isset($_GET['search']))  ?  trim($_GET['search'])  :  "";
        $this->total_searched    = 0;
        $this->total_found       = 0;
        $this->search_pattern    = "";
        $this->extension_pattern = "";

        $this->error_message = "";

        $this->powerthumb_file = "";
        $this->thumb           = false;
    }



    function search()
    {

        if (!isset($_GET['search']))
        {
            return false;
        }


        // Changes flags to make sure the search will be in documents OR images, not both

        if ($this->search_in_docs  &&  $this->search_in_imgs)
        {
            if (isset($_GET['search_in'])  &&  $_GET['search_in'] == 'imgs')
            {            
                $this->search_in_docs = false;
            }
            else
            {
                $this->search_in_imgs = false;
            }
        }
        else if (!$this->search_in_imgs)
        {
            $this->search_in_docs = true;
        }
        else if (!$this->search_in_docs)
        {
            $this->search_in_imgs = true;
        }



        // Starts time counter
        $start = $this->getMicrotime();



        // Creates a search pattern

        if ($this->exact_search  &&  strlen($this->search) > $this->minimun_word_size)
        {
            $this->search_pattern = $this->createPattern($this->search);
        }
        else
        {
            $search_words = array();
            foreach (explode(" ", $this->search) as $word)
            {
                if (strlen($word) < $this->minimun_word_size)
                {
                    continue;
                }

                $search_words[] = $this->createPattern($word);
            }

            $this->search_pattern = implode("|", $search_words);

            unset($search_words);
        }


        // Creates extensions pattern, and if the search is for images, try to load PowerThumb class

        if ($this->search_in_docs)
        {
            $this->extension_pattern = '(' . implode("|", $this->documents_extension_list) . ')$';
        }
        else if ($this->search_in_imgs)
        {
            $this->extension_pattern = '(' . implode("|", $this->images_extension_list) . ')$';

            if (!class_exists("PowerThumb")) {
                if (file_exists($this->powerthumb_file)) {
                    include_once $this->powerthumb_file;
                }
                else if (file_exists(dirname(__FILE__) . '/class.thumb.php')) {
                    include_once dirname(__FILE__) . '/class.thumb.php';
                }
                else if (file_exists(dirname(__FILE__) . '/class.thumbs.php')) {
                    include_once dirname(__FILE__) . '/class.thumbs.php';
                }
            }

            if (class_exists("PowerThumb"))
            {
                $this->thumb = new PowerThumb();
                $this->thumb->setStyle("float", "left");
                $this->thumb->setStyle("margin", "5px");
                $this->thumb->setStyle("border", "1px solid #999999");
            }
        }



        if (isset($_GET['section'])  &&  isset($this->section_list[$_GET['section']]))
        {
            $this->search_dir_list = array($this->section_list[$_GET['section']]);
        }




        // Verifies for valid patterns

        if ($this->search_pattern == "")
        {
            $this->error_message = "Search words must have at least " . $this->minimun_word_size . " caracteres.";
            return false;
        }

        else if ($this->extension_pattern == "")
        {
            $this->error_message = $this->error("No file extensions were defined.");
            return false;
        }

        else if (!(count($this->search_dir_list) > 0))
        {
            $this->error_message = "Please select a section.";
            return false;
        }



        ini_set("max_execution_time", "120");
        ini_set("memory_limit", "10000000");





        $protocol      = explode("/", strtolower($_SERVER['SERVER_PROTOCOL']));
        $host          = $protocol[0] . "://" . $_SERVER['HTTP_HOST'];
        $printing_page = $page = 1;


        $html = "\n\n  <div id=\"page_1\" style=\"display: block;\">";

        while (($dir = array_shift($this->search_dir_list)) !== NULL)
        {
            if (($dh = @opendir($dir)) === false)
            {
                $this->error("Could not open search directory!");
            }


            while (($file = @readdir($dh)) !== false)
            {
                $file_path = $dir . $file;

                if (is_dir($file_path))
                {
                    if ($file == "."  ||  $file == ".."  ||  in_array(realpath($file_path), $this->excluded_dir_list))
                    {
                        continue;
                    }

                    // Feeds search dir list with subdirectories
                    $this->search_dir_list[] = $file_path.'/';
                    continue;
                }

                else if (!preg_match("/".$this->extension_pattern."/i",  $file))
                {
                    continue;
                }


                $this->total_searched++;


                if ($this->search_in_docs) {
                    $file_content = @file_get_contents($file_path);
                    $file_content = html_entity_decode($this->clearSpaces($this->stripScriptTags($file_content)));
                }
                else if ($this->search_in_imgs) {
                    $file_content = "";
                }



                if (preg_match("'".$this->search_pattern."'si", $file_content, $matches, PREG_OFFSET_CAPTURE)  ||  
                    preg_match("'".$this->search_pattern."'i", $file))
                {

                    $this->total_found++;

                    $position = isset($matches[0][1])  ?  $matches[0][1]  :  0;



                    $page = ceil($this->total_found / $this->results_per_page);

                    if ($this->total_found == 1)
                    {
                        $html .= "\n\n    <script type=\"text/javascript\">\n      show_pages_links(" . ($page) . ");\n    </script>\n";
                    }
                    else if ($page != $printing_page)
                    {
                        $printing_page = $page;

                        $html .= "\n\n    <script type=\"text/javascript\">\n      show_pages_links(" . ($page-1) . ");\n    </script>\n";
                        $html .= "\n  </div>";
                        $html .= "\n  <div id=\"page_" . $page . "\" style=\"display: none;\">";
                        $html .= "\n\n    <script type=\"text/javascript\">\n      show_pages_links(" . ($page) . ");\n    </script>\n";
                    }



                    $path  = $this->realPath($host . dirname($_SERVER['SCRIPT_NAME']) . "/" . $file_path);

                    $title = $this->getTitle($file_content);

                    if ($title == "")
                    {
                        $title = $path;
                    }


                    // Sets "description"

                    if ($this->search_in_docs)
                    {
                        $file_content = $this->clearSpaces(strip_tags($file_content));

                        if ($position < 120) {
                            $description = substr($file_content, 0, 350);
                        }
                        else {
                            $description = substr($file_content, ($position-120), ($position+120));

                            if (strlen($description) > 350) {
                                $description = substr($description, 0, 350);
                            }
                        }

                        $description = preg_replace("'^([^\s]*\s.*?)\s[^\s]*$'i", "\\1", $description);
                        $description = preg_replace("'(".$this->search_pattern.")'i", "<strong><span class=\"highlight\">\\1</span></strong>", $description);

                        if ($description == "") {
                            $description = "No description.";
                        }
                        else if (strlen($description) < strlen($file_content)) {
                            $description .= " ...";
                        }
                    }

                    else if ($this->search_in_imgs)
                    {
                        $description = "";
                        $title       = $file;
                        $info        = getimagesize($file_path);

                        if ($this->thumb) {
                            $description .= $this->thumb->create($file_path, false);
                        }

                        $description .= "Size: " . $info[0] . " x " . $info[1] . " pixels<br />";
                        $description .= "Bits: " . $info['bits'] . "<br />";
                        $description .= (isset($info['channels']))  ?  "Channels: " . $info['channels'] . "<br />"  :  "";
                        $description .= "Mime-type: " . $info['mime'] . "<br /><br />";
                        $description .= '<a href="' . $file_path . '">' . $path . '</a>';
                        $description .= "\n".'<div style="clear: both;"></div>';

                        $path = "";
                    }



                    $html .= "\n<p style=\"margin: 30px 0px;\">";
                    $html .= "\n  <div class=\"title\">";
                    $html .= "\n    ".$this->total_found . '. <a href="'.$file_path.'">' . $title . '</a>';
                    $html .= "\n  </div>";
                    $html .= "\n  <div class=\"description\">";
                    $html .= "\n    " . $description;
                    $html .= "\n  </div>";
                    $html .= "\n  <div class=\"path\">";
                    $html .= "\n    <a href=\"" . $file_path . "\">" . $path . "</a>";
                    $html .= "\n  </div>";
                    $html .= "\n</p>\n";


                } //  if (preg_match("'".$this->search_pattern."'si", $file_content, $matches, PREG_OFFSET_CAPTURE))

            } //  while (($file = @readdir($dh)) !== false)

            @closedir($dh);

        } //  while (($dir = array_shift($this->search_dir_list)) != false)

        $html .= "  <script type=\"text/javascript\">\n  show_pages_links(" . $page . ");\n</script>\n";
        $html .= "</div>";

        clearstatcache();

        $this->search_time = number_format(  ($this->getMicrotime() - $start)  , 2, ".", ",");



        $javascript  = "\n  <script type=\"text/javascript\">";
        $javascript .= "\n    var showed_page = 1;";
        $javascript .= "\n    var total_pages = " . $page . ";";  // last value assigned to $page is equal to the total of pages
        $javascript .= "\n";
        $javascript .= "\n    function show_page(id) {";
        $javascript .= "\n        hide_page(showed_page);";
        $javascript .= "\n        document.getElementById('page_' + id).style.display = 'block';";
        $javascript .= "\n        showed_page = id;";
        $javascript .= "\n    }";
        $javascript .= "\n";
        $javascript .= "\n    function hide_page(id) {";
        $javascript .= "\n        document.getElementById('page_' + id).style.display = 'none';";
        $javascript .= "\n    }";
        $javascript .= "\n";
        $javascript .= "\n    function show_pages_links(page_number) {";
        $javascript .= "\n        document.write('<div class=\"pages_links\">');";
        $javascript .= "\n";
        $javascript .= "\n        if (page_number > 1) {";
        $javascript .= "\n            document.write('<a href=\"javascript: scroll(0, 0);\" onclick=\"javascript: show_page(' + (page_number-1) + ');\">');";
        $javascript .= "\n        }";
        $javascript .= "\n        document.write(' &lt;&lt; Previous ');";
        $javascript .= "\n        if (page_number > 1) {";
        $javascript .= "\n            document.write('</a>');";
        $javascript .= "\n        }";
        $javascript .= "\n";
        $javascript .= "\n        document.write(' | ');";
        $javascript .= "\n";
        $javascript .= "\n        for (var i = 1; i <= total_pages; i++) {";
        $javascript .= "\n            if (page_number != i) {";
        $javascript .= "\n                document.write('<a href=\"javascript: scroll(0, 0);\" onclick=\"javascript: show_page(' + i + ');\">');";
        $javascript .= "\n            }";
        $javascript .= "\n            document.write(i);";
        $javascript .= "\n            if (page_number != i) {";
        $javascript .= "\n                document.write('</a>');";
        $javascript .= "\n            }";
        $javascript .= "\n            document.write(' | ');";
        $javascript .= "\n        }";
        $javascript .= "\n";
        $javascript .= "\n";
        $javascript .= "\n        if ((total_pages > 1) && (page_number < total_pages)) {";
        $javascript .= "\n            document.write('<a href=\"javascript: scroll(0, 0);\" onclick=\"javascript: show_page(' + (page_number+1) + ');\">');";
        $javascript .= "\n        }";
        $javascript .= "\n        document.write(' Next &gt;&gt; ');";
        $javascript .= "\n        if ((total_pages > 1) && (page_number < total_pages)) {";
        $javascript .= "\n            document.write('</a>');";
        $javascript .= "\n        }";
        $javascript .= "\n";
        $javascript .= "\n        document.write('</div>');";
        $javascript .= "\n    }";
        $javascript .= "\n";
        $javascript .= "\n  </script>";



        $result  = $javascript;
        $result .= $html;

        return $result;
    }



    function getMicrotime() {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }

    function getTitle($html) {
        $title = "";
        if (preg_match("'<title>'si", $html)) {
            $title = preg_replace("'^.*?<title>|</title>.*$'si", "", $html);
            if (empty($title)) {
                $title = "Untitled Page";
            }
        }
        return strip_tags($title);
    }

    function stripScriptTags($string) {
        $pattern = array("'\/\*.*\*\/'si", "'<\?.*?\?>'si", "'<%.*?%>'si", "'<script[^>]*?>.*?</script>'si");
        $replace = array("", "", "", "");
        return preg_replace($pattern, $replace, $string);
    }

    function clearSpaces($string, $clear_enters = true) {
        $pattern = ($clear_enters == true) ? ("/\s+/") : ("/[ \t]+/");
        return preg_replace($pattern, " ", trim($string));
    }

    function createPattern($string) {
        $string  = preg_replace("/([\.\/\*\+\-\?\^\|\$\(\)\[\]\{\}\"\'\\\\])/s", "\\\\\\1", $string);
        $pattern = array("/[a�����]/si", "/[e����]/si", "/[i����]/si", "/[o�����]/si", "/[u����]/si", "/[�]/si", "/[�]/si", "/\s+/s");
        $replace = array("[a�����]",     "[e����]",     "[i����]",     "[o�����]",     "[u����]",     "[�c]",    "[�n]",    "\s*");
        return preg_replace($pattern, $replace, addslashes($string));
    }

    function realPath($path)
    {
        if ($path == "")
        {
            return false;
        }

        $path = trim(preg_replace("/\\\\/", "/", (string)$path));

        if (!preg_match("/(\.\w{1,4})$/", $path)  &&  !preg_match("/\?[^\\/]+$/", $path)  &&  !preg_match("/\\/$/", $path))
        {
            $path .= '/';
        }

        preg_match_all("/^(\\/|\w:\\/|https?:\\/\\/[^\\/]+\\/)?(.*)$/i", $path, $matches, PREG_SET_ORDER);

        $path_root = $matches[0][1];
        $path_dir  = $matches[0][2];

        $path_dir   = preg_replace(  array("/^\\/+/", "/\\/+/"),  array("", "/"),  $path_dir  );
        $path_parts = explode("/", $path_dir);

        for ($i = $j = 0, $real_path_parts = array(); $i < count($path_parts); $i++)
        {
            if ($path_parts[$i] == '.')
            {
                continue;
            }
            else if ($path_parts[$i] == '..')
            {
                if (  (isset($real_path_parts[$j-1])  &&  $real_path_parts[$j-1] != '..')  ||  ($path_root != "")  )
                {
                    array_pop($real_path_parts);
                    $j--;
                    continue;
                }
            }

            array_push($real_path_parts, $path_parts[$i]);
            $j++;
        }

        return $path_root . implode('/', $real_path_parts);
    }


    function error($message)
    {
        return '<span style="padding: 1px 7px 1px 7px; background-color: #ffd7d7; font-family: verdana; color: #000000; font-size: 13px;"><span style="color: #ff0000; font-weight: bold;">Error!</span> ' . $message . '</span><br /><br /><br />';
	}




    /*@#+
    *  @access public
    */
    function addSection($section, $dir)
    {
        $this->section_list[(string)$section] = (string)$dir;
    }

    function hideDir($dir)
    {
        $this->excluded_dir_list[] = realpath((string)$dir);
    }


    function addDocumentExtension($extension)
    {
        $this->documents_extension_list[] = (string)$extension;
    }

    function hideDocumentExtension($extension)
    {
        foreach ($this->documents_extension_list as $i => $ext)
        {
            if ($ext == $extension)
            {
                unset($this->documents_extension_list[$i]);
                break;
            }
        }
    }


    function addImageExtension($extension)
    {
        $this->images_extension_list[] = (string)$extension;
    }

    function hideImageExtension($extension)
    {
        foreach ($this->images_extension_list as $i => $ext)
        {
            if ($ext == $extension)
            {
                unset($this->images_extension_list[$i]);
                break;
            }
        }
    }


    function searchInDocuments($search = true)
    {
        $this->search_in_docs = (bool)$search;
    }


    function searchInImages($search = true)
    {
        $this->search_in_imgs = (bool)$search;
    }

    function showDetails($show = true)
    {
        $this->show_details = (bool)$show;
    }



    function form($should_print = true)
    {
        if (isset($_SERVER['SCRIPT_NAME'])) {
            $action = $_SERVER['SCRIPT_NAME'];
        } else if (isset($_SERVER['PHP_SELF'])) {
            $action = $_SERVER['PHP_SELF'];
        } else if (isset($_SERVER['PATH_TRANSLATED'])) {
            $action = basename($_SERVER['PATH_TRANSLATED']);
        } else {
            $action = "#";
        }


        $search_in_docs = $this->search_in_docs;
        $search_in_imgs = $this->search_in_imgs;

        if ($search_in_docs  &&  $search_in_imgs)
        {
            if (isset($_GET['search_in'])  &&  $_GET['search_in'] == 'imgs')
            {            
                $search_in_docs = false;
            }
            else
            {
                $search_in_imgs = false;
            }
        }
        else if (!$search_in_imgs)
        {
            $search_in_docs = true;
        }
        else if (!$search_in_docs)
        {
            $search_in_imgs = true;
        }



        $checked_search_in_docs = ($search_in_docs)        ?  ' checked="checked"' : "";
        $checked_search_in_imgs = ($search_in_imgs)        ?  ' checked="checked"' : "";
        $checked_exact_search   = ($this->exact_search)    ?  ' checked="checked"' : "";


        if (count($this->section_list) > 1)
        {
            $sections  = "\n".'    <select name="section" id="section">';
            $sections .= "\n".'      <option value="">--- section ---</option>';

            foreach ($this->section_list as $section_name => $section_path)
            {
                $selected  = (isset($_GET['section'])  &&  $_GET['section'] == $section_name)  ?  ' selected="selected"'  :  "";
                $sections .= "\n".'      <option value="' . $section_name . '"' . $selected . '>' . $section_name . '</option>';
            }

            $sections .= "\n".'    </select>';
        }
        else
        {
            $sections = "";

            foreach ($this->section_list as $section_name => $section_path)
            {
                $sections .= "\n".'    <input type="hidden" name="section" id="section" value="' . $section_name . '" />';
            }
        }


        $html  = "\n".'<form action="' . $action . '" method="get" name="search_form" style="text-align: center;" id="search_form">';
        $html .= "\n".'  <div class="search_input">';
        $html .= "\n".'    Search for';
        $html .= "\n".'    <input type="text" name="search" id="search" value="' . $this->search . '" />';
        $html .= $sections;
        $html .= "\n".'    <input type="submit" id="submit_button" value="search" />';
        $html .= "\n".'  </div>';

        if ($this->search_in_docs && $this->search_in_imgs)
        {
            $html .= "\n".'  <div class="search_type">';
            $html .= "\n".'    <input type="radio" name="search_in" id="search_in" value="docs"' . $checked_search_in_docs . ' /> Documents';
            $html .= "\n".'    <input type="radio" name="search_in" id="search_in" value="imgs"' . $checked_search_in_imgs . ' /> Images';
            $html .= "\n".'  </div>';
        }

        $html .= "\n".'  <div class="search_type">';
        $html .= "\n".'    <input type="checkbox" name="exact_search" id="exact_search" value="yes"' . $checked_exact_search . ' /> Exact Search';
        $html .= "\n".'  </div>';
        $html .= "\n</form>\n";

        if ($should_print) {
            echo $html;
        } else {
            return $html;
        }
    }



    function results($print = true)
    {
        $search = $this->search();

        $html = "\n<div id=\"search_results\">";


        if (!$search)
        {
            $html .= $this->error_message;
        }
        else if ($this->show_details)
        {
            $html .= "\n Found " . $this->total_found . " matches in " . $this->total_searched . " files<br />";
            $html .= "\n Time: " . $this->search_time . " sec<br />";
        }

        $html .= $search;
        $html .= "\n</div>";

        if ($print) {
            echo $html;
        } else {
            return $html;
        }
    }
    //@#+

}



?>