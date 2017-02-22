<?php
/**
 * Client test for Litmus.
 *
 * @package Webdav
 * @subpackage Tests
 * @version 1.1.4
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'client_test_suite.php';
require_once 'client_test_continuous_setup.php';

/**
 * Client test for Litmus
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavLitmusClientTest extends ezcTestCase
{
    public static function suite()
    {
        return new ezcWebdavClientTestSuite(
            'Litmus',
            'clients/litmus.php',
            new ezcWebdavClientTestContinuousSetup()
        );
    }
}

?>
