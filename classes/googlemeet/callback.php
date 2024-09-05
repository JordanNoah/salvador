<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.


/**
 * Oauth client instance callback script
 *
 * @package    local_digitalta
 * @copyright  2024 ADSDR-FUNIBER Scepter Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace local_digitalta;

require_once(__DIR__ . '/../../../../config.php');
require_once($CFG->dirroot . '/local/digitalta/lib.php');
require_once($CFG->dirroot . '/local/digitalta/classes/googlemeet/client.php');

use local_digitalta\GoogleMeetClient;

require_login();

// Headers to make it not cacheable.
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');

// Wait as long as it takes for this script to finish.
\core_php_time_limit::raise();

$chatid = required_param('chatid', PARAM_INT);

$client = new GoogleMeetClient();


// Post callback.
$response = $client->callback($chatid);

$openMeetingHTML = $response ? 'window.open("' . $response . '", "_blank");' : '';

  // If this request is coming from a popup, close window and reload parent window.
$js = <<<EOD
<html>
<head>
    <script type="text/javascript">
        window.opener.location.reload();
        $openMeetingHTML
        window.close();
    </script>
</head>
<body></body>
</html>
EOD;
die($js);
