<?php
/**
* @package PHPVer
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc PHP Version class
* @uses
* @example
* @files
*/


/**
<p>This class splits a php version number into its different components.  The 
supported components are:
<ul>
<li>Major Version</li>
<li>Minor Version</li>
<li>Revision Number</li>
<li>Release Candidate Number</li>
<li>Beta Version Number</li>
<li>Alpha Version Number</li>
<li>Patch Level Number</li>
</ul>

<p>By default, all of the above components are -1.  If a component is not -1,
that means there is a value for that component.

<p>This class also contains a compare function for comparing two version numbers
together.  It compares the version number associated with this class and a
version number that is passed in as an argument.  If the passed in version number
is newer than the version number associated with this class, 1 is returned, if
the passed in version number is older than the version number associated with this
class, -1 is returned, and if they are equal, 0 is returned.

@access public
*/
class PHPVer {

    var $_versionString;
    var $_majorVersion;
    var $_minorVersion;
    var $_revision;
    var $_alpha;
    var $_beta;
    var $_patchLevel;
    var $_releaseCandidate;

    
    /**
    This is the constructor for the PHP Version class.  If a version number is passed
    in, that version number is used, otherwise the version number is defined by the
    <code>phpversion()</code> function.  The version number is then parsed out into
    its components.

    @param $version An optional paramater specifying a version number.  If not passed
    in, the value from <code>phpversion()</code> is used.

    @access public
    */
    function PHPVer($version = "") {
        $this->_versionString = -1;
        $this->_majorVersion = -1;
        $this->_minorVersion = -1;
        $this->_revision = -1;
        $this->_alpha = -1;
        $this->_beta = -1;
        $this->_patchLevel = -1;
        $this->_releaseCandidate = -1;

        if (empty($version)) {
            $this->_versionString = trim(phpversion());
        } else {
            $this->_versionString = trim($version);
        }

        $arr = explode(".", $this->_versionString);

        // set major version and its information
        if ($arr[0] != "") {
            $result = $this->setNumericPart($arr[0], $this->_majorVersion);
            $result = $this->setSubVersion($result);
        }

        // set minor version and its information
        if ($arr[1] != "") {
            $result = $this->setNumericPart($arr[1], $this->_minorVersion);
            $result = $this->setSubVersion($result);
        }

        // set revision and its information
        if ($arr[2] != "") {
            $result = $this->setNumericPart($arr[2], $this->_revision);
            $result = $this->setSubVersion($result);
        }
    }


    /**
    This function returns true if <code>$ident</code> is the first
    characters in the string <code>$str</code>.  Returns false
    otherwise

    @param $str The string in which to search for <code>$ident</code>.

    @param $ident The string to search for in <code>$str</code>.

    @return boolean True if <code>$ident</code> is the first characters
    in <code>$str</code>.  False otherwise.

    @access private
    */
    function isIdentifier($str, $ident) {
        return (strtolower(substr($str, 0, strlen($ident))) == $ident);
    }


    /**
    This function sets all of the fields that are not major, minor or 
    revision numbers.  This includes alpha revisions, beta revisions,
    patch levels and release candidates.

    @param $str The string to search for the subversion information.  This
    string must contain a subversion identifier in its first characters
    (i.e. p14 is patch level 14).  It can not contain the version number.

    @return string The string left over after search for all subversion
    identifiers.  All identifiers and information associated with those
    identifiers will have been stripped from the string.  If the string
    passed in is a valid php version string, this function will usually
    return an empty string.

    @access private
    */
    function setSubVersion($str) {
        $done = false;
        while (!$done && !(empty($str))) {
            switch (true) {

            case $this->isIdentifier($str, "a"):
                $str = $this->setNumericPart(substr($str, 1), $this->_alpha);
                break;
            
            case $this->isIdentifier($str, "b"):
                $str = $this->setNumericPart(substr($str, 1), $this->_beta);
                break;

            case $this->isIdentifier($str, "pl"):
                $str = $this->setNumericPart(substr($str, 2), $this->_patchLevel);
                break;
            
            case $this->isIdentifier($str, "-pl"):
                $str = $this->setNumericPart(substr($str, 3), $this->_patchLevel);
                break;
            
            case $this->isIdentifier($str, "rc"):
                $str = $this->setNumericPart(substr($str, 2), $this->_releaseCandidate);
                break;
            
            case $this->isIdentifier($str, "-rc"):
                $str = $this->setNumericPart(substr($str, 3), $this->_releaseCandidate);
                break;
            
            default:
                $done = true;
                break;
            }
        }

        return $str;
    }
    
    /**
    This function takes a string and returns a number identified by the first
    x characters in the string.  It goes through the string one character at
    a time until it finds a non-numeric character.  The substring that is the
    number up to that point is then returned to the caller in <code>$result</code>
    and the rest of the string from that point forward is returned by the
    function.

    @param $str The string in which to search for a number

    @param $result The resulting number from searching through <code>$str</code>.

    @return string The resulting number from searching through <code>$str</code> is
    passed back to the caller in <code>$result</code>

    @return string The substring that is left after searching through
    <code>$str</code> for a number.

    @access private
    */
    function setNumericPart($str, &$result) {
        $result = "";

        for ($i = 0; ($i < strlen($str)) && ((string)intval(substr($str, $i, 1)) == (string)substr($str, $i, 1)); $i++) {
            $result .= substr($str, $i, 1);
        }

        if ($i == strlen($str)) {
            return "";
        } else {
            return substr($str, $i);
        }
    }

    
    /**
    Returns the major version number after parsing the version string

    @return string The major version number

    @access public
    */
    function getMajorVersion() {
        return $this->_majorVersion;
    }

    
    /**
    Returns the minor version number after parsing the version string

    @return string The minor version number

    @access public
    */
    function getMinorVersion() {
        return $this->_minorVersion;
    }


    /**
    Returns the revision number after parsing the version string

    @return string The revision number

    @access public
    */
    function getRevision() {
        return $this->_revision;
    }


    /**
    Returns the alpha revision number after parsing the version string

    @return string The alpha revision number

    @access public
    */
    function getAlphaRevision() {
        return $this->_alpha;
    }


    /**
    Returns the beta revision number after parsing the version string

    @return string The beta revision number

    @access public
    */
    function getBetaRevision() {
        return $this->_beta;
    }


    /**
    Returns the patch level number after parsing the version string

    @return string The patch level number

    @access public
    */
    function getPatchLevelRevision() {
        return $this->_patchLevel;
    }


    /**
    Returns the release candidate revision number after parsing the version string

    @return string The release candidate revision number

    @access public
    */
    function getReleaseCandidateRevision() {
        return $this->_releaseCandidate;
    }


    /**
    Returns the version string passed into the class or found through the
    <code>phpversion()</code> function.

    @return string The version string

    @access public
    */
    function getVersionString() {
        return $this->_versionString;
    }


    /**
    This function compares the version number associated with this class and a
    version number that is passed in as an argument.  If the passed in version number
    is newer than the version number associated with this class, 1 is returned, if
    the passed in version number is older than the version number associated with this
    class, -1 is returned, and if they are equal, 0 is returned. 

    @param $sVer The version to compare with the verions associated with this class.

    @return integer -1 if <code>$sVer</code> is older than the version associated 
    with this class, 1 if <code>$sVer</code> is newer than the version associated
    with this class and 0 if the versions are equal.

    @access public
    */
    function compare($sVer) {
        $cmpVer = new PHPVer($sVer);

        if ($cmpVer->getVersionString() == $this->getVersionString()) {
            return 0;
        }

        if (($cmpVer->getMajorVersion() == -1) && ($this->getMajorVersion() > -1)) {
            return -1;
        } else if (($cmpVer->getMajorVersion() > -1) && ($this->getMajorVersion() == -1)) {
            return 1;
        } else if (($cmpVer->getMajorVersion() > -1) && ($this->getMajorVersion() > -1)) {
            switch(true) {
            
            case ($cmpVer->getMajorVersion() < $this->getMajorVersion()):
                return -1;

            case ($cmpVer->getMajorVersion() > $this->getMajorVersion()):
                return 1;

            }
        }


        if (($cmpVer->getMinorVersion() == -1) && ($this->getMinorVersion() > -1)) {
            return -1;
        } else if (($cmpVer->getMinorVersion() > -1) && ($this->getMinorVersion() == -1)) {
            return 1;
        } else if (($cmpVer->getMinorVersion() > -1) && ($this->getMinorVersion() > -1)) {
            switch(true) {
            
            case ($cmpVer->getMinorVersion() < $this->getMinorVersion()):
                return -1;

            case ($cmpVer->getMinorVersion() > $this->getMinorVersion()):
                return 1;

            }
        }


        if (($cmpVer->getRevision() == -1) && ($this->getRevision() > -1)) {
            return -1;
        } else if (($cmpVer->getRevision() > -1) && ($this->getRevision() == -1)) {
            return 1;
        } else if (($cmpVer->getRevision() > -1) && ($this->getRevision() > -1)) {
            switch(true) {
            
            case ($cmpVer->getRevision() < $this->getRevision()):
                return -1;

            case ($cmpVer->getRevision() > $this->getRevision()):
                return 1;

            }
        }


        if (($cmpVer->getReleaseCandidateRevision() == -1) && ($this->getReleaseCandidateRevision() > -1)) {
            // compare version is not release candidate, but this version is
            if ($cmpVer->getBetaRevision() > -1 || $cmpVer->getAlphaRevision() > -1) {
                return -1;
            }
        } else if (($cmpVer->getReleaseCandidateRevision() > -1) && ($this->getReleaseCandidateRevision() == -1)) {
            // this version is not release candidate, but compare version is
            if ($this->getBetaRevision() > -1 || $this->getAlphaRevision() > -1) {
                return 1;
            }
        } else if (($cmpVer->getReleaseCandidateRevision() > -1) && ($this->getReleaseCandidateRevision() > -1)) {
            switch(true) {
            
            case ($cmpVer->getReleaseCandidateRevision() < $this->getReleaseCandidateRevision()):
                return -1;

            case ($cmpVer->getReleaseCandidateRevision() > $this->getReleaseCandidateRevision()):
                return 1;

            }
        }


        if (($cmpVer->getBetaRevision() == -1) && ($this->getBetaRevision() > -1)) {
            // compare version is not beta, but this version is
            if ($cmpVer->getAlphaRevision() > -1) {
                return -1;
            }
        } else if (($cmpVer->getBetaRevision() > -1) && ($this->getBetaRevision() == -1)) {
            // this version is not beta, but compare version is
            if ($this->getAlphaRevision() > -1) {
                return 1;
            }
        } else if (($cmpVer->getBetaRevision() > -1) && ($this->getBetaRevision() > -1)) {
            switch(true) {
            
            case ($cmpVer->getBetaRevision() < $this->getBetaRevision()):
                return -1;

            case ($cmpVer->getBetaRevision() > $this->getBetaRevision()):
                return 1;

            }
        }


        if (($cmpVer->getAlphaRevision() == -1) && ($this->getAlphaRevision() > -1)) {
            // compare version is not alpha, but this version is
            return 1;
        } else if (($cmpVer->getAlphaRevision() > -1) && ($this->getAlphaRevision() == -1)) {
            // this version is not alpha, but compare version is
            return -1;
        } else if (($cmpVer->getAlphaRevision() > -1) && ($this->getAlphaRevision() > -1)) {
            switch(true) {
            
            case ($cmpVer->getAlphaRevision() < $this->getAlphaRevision()):
                return -1;

            case ($cmpVer->getAlphaRevision() > $this->getAlphaRevision()):
                return 1;

            }
        }


        if (($cmpVer->getPatchLevelRevision() == -1) && ($this->getPatchLevelRevision() > -1)) {
            return -1;
        } else if (($cmpVer->getPatchLevelRevision() > -1) && ($this->getPatchLevelRevision() == -1)) {
            return 1;
        } else if (($cmpVer->getPatchLevelRevision() > -1) && ($this->getPatchLevelRevision() > -1)) {
            switch(true) {
            
            case ($cmpVer->getPatchLevelRevision() < $this->getPatchLevelRevision()):
                return -1;

            case ($cmpVer->getPatchLevelRevision() > $this->getPatchLevelRevision()):
                return 1;

            }
        }


        return 0;
    }

}
?>