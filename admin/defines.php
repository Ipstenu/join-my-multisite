<?php
/*
    This file is part of Join My Multisite, a plugin for WordPress.

    Join My Multisite is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 2 of the License, or
    (at your option) any later version.

    Join My Multisite is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with WordPress.  If not, see <http://www.gnu.org/licenses/>.

*/

if (!defined('ABSPATH')) {
    die();
}

define( 'JMM', true);

if ( !defined('join_my_multisite')) {define('join_my_multisite','join_my_multisite');} // Translation 

defined('JMM_PLUGIN_DIR') || define('JMM_PLUGIN_DIR', realpath(dirname(__FILE__) . '/..'));

if (!get_option( 'helfjmm_options' )) {
    $jmm_options = get_option( 'helfjmm_options' );
        if ( !isset($jmm_options['type']) ) $jmm_options['type'] = '3';
        if ( !isset($jmm_options['role']) ) $jmm_options['role'] = 'subscriber';
        if ( !isset($jmm_options['persite']) ) $jmm_options['persite'] = '0';
        if ( !isset($jmm_options['perpage']) ) $jmm_options['perpage'] = 'XXXXXX'; // blank
    update_option('helfjmm_options', $jmm_options);
}