<?php

/**
* @package wml_doc
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc 
* @uses
* @example
* @files
*/


  /*
  **  class wml_doc
  **
  **  Klasa odzwierciedla dokument WML. Mo�na zdefiniowa� kodowanie znak�w ( ->encoding ), etc.
  **  Wy�wietlenie dokumentu metod� ->show()
  */
  class wml_doc {
    var $content_type = "text/vnd.wap.wml";
    var $cache = "no-store, no-cache, must-revalidate, post-check=0, pre-check=0";
    var $encoding = "utf-8";
    var $cards = array();
    var $template = array();

    function add_card($card) {
      $this->cards[] = $card;
    }

    function add_button($title, $action = "prev", $href = "") {
      $action = strtolower($action);
      // check - is right action?
      if ($action != "prev" && $action != "options") $action = "prev";
      $temparray[title] = $title;
      $temparray[action] = $action;
      $temparray[href] = $href;
      $this->template[] = $temparray;
      unset($temparray);
    }

    function show() {
      if ($this->content_type != "") header("Content-Type: ".$this->content_type);
      if ($this->cache != "") header("Cache-Control: ".$this->cache);
      if ($this->encoding != "") $enc = " encoding=\"".$this->encoding."\""; else $enc = "";
      print("<?phpxml version=\"1.0\"".$enc."?>\n");
      print("<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.1//EN\" \"http://www.wapforum.org/DTD/wml_1.1.xml\">\n");
      print("<wml>\n");
      if ($this->cache != "") {
        print("<head>\n");
        print("<meta http-equiv=\"Cache-Control\" content=\"".$this->cache."\"/>\n");
        print("</head>\n");
      }
      if (count($this->template) > 0) {
        print("<template>\n");
        for ($tc = 0; $tc < count($this->template); $tc ++) {
          $at = $this->template[$tc];
          $rets = "<do type=\"".$at[action]."\" label=\"".$at[title]."\">";
          if ($at[action] == "prev") $rets .= "<prev/>"; else $rets .= "<go href=\"".$at[href]."\"/>";
          $rets .= "</do>\n";
          print($rets);
        }
        print("</template>\n");
      }
      for ($cc = 0; $cc < count($this->cards); $cc ++) {
        $card = $this->cards[$cc];
        if (!empty($card->timer)) $timr = " ontimer=\"".$card->timer[url]."\""; else $timr = "";
        print("<card id=\"".$card->id."\" title=\"".$card->title."\"".$timr.">\n");
        if (!empty($card->timer)) print("<timer name=\"".$card->timer[name]."\" value=\"".$card->timer[time]."\"/>\n");
        for ($clc = 0; $clc < count($card->source); $clc ++) print($card->source[$clc]."\n");
        print("</card>\n");
      }
      print("</wml>\n");
    }
  }

  /*
  **  class wml_card
  **
  **  Klasa odzwierciedla kart� dokumentu WML.
  **  Dokument WML _musi_ zawiera� co najmniej jedn� kart�.
  */
  class wml_card {
    var $id = "main";
    var $title = "Main";
    var $source = array();
    var $timer = array();

    function create($title = "Main", $id = "main") {
      $this->id = $id;
      $this->title = $title;
    }

    function add_timer($time, $url, $name = "maintimer") {
      $this->timer[time] = $time;
      $this->timer[url] = $url;
      $this->timer[name] = $name;
    }

    function add($code) {
      $this->source[] = $code;
    }
  }

  /*
  **  function wml_link ( link target, link content )
  */
  function wml_link($href, $source) {
    return "<a href=\"$href\">$source</a>";
  }

  /*
  **  function wml_image ( image location [, alt text content] )
  */
  function wml_image($href, $alt = "!!NO_ALT!!") {
    if ($alt == "!!NO_ALT!!") $alt = &$href;
    return "<img src=\"$href\" alt=\"$alt\"/>";
  }

  /*
  **
  **  Funkcje dla klasy wml_doc:
  **
  **    void add_card(object card)
  **    void show(void)
  **
  **  Funkcje dla klasy wml_card:
  **
  **    void create([string title] [, string id])
  **    void add_timer(string time, string url [, string name])
  **    void add(string code)
  **
  */
?>