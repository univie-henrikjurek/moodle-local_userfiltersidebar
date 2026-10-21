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

namespace local_userfiltersidebar;

use core\hook\output\before_standard_head_html_generation;
use html_writer;
use moodle_url;

/**
 * Hook callbacks
 *
 * @package    local_userfiltersidebar
 * @copyright  2026 henrik <henrik.jurek@univie.ac.at>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class hook_callbacks {

    /**
     * Cache buster for the plugin stylesheet.
     *
     * Bump this number whenever styles.css is changed so that browsers
     * request the updated file.
     */
    private const CSS_VERSION = 7;

    /**
     * Page type of the administrative user list page (/admin/user.php).
     */
    private const USERS_PAGE_TYPE = 'admin-user';

    /**
     * Add the filter sidebar stylesheet to the page head.
     *
     * The stylesheet is only emitted on the administrative user list page,
     * all other pages are left completely untouched.
     *
     * @param before_standard_head_html_generation $hook
     */
    public static function before_standard_head_html_generation(
        before_standard_head_html_generation $hook,
    ): void {
        global $PAGE;

        // Only load the stylesheet on the administrative user list page.
        if ($PAGE->pagetype !== self::USERS_PAGE_TYPE) {
            return;
        }

        $url = new moodle_url('/local/userfiltersidebar/styles.css', ['version' => self::CSS_VERSION]);
        $hook->add_html(html_writer::empty_tag('link', [
            'rel' => 'stylesheet',
            'type' => 'text/css',
            'href' => $url->out(),
        ]));
    }
}
