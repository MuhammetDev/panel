<?php
/**
 * get_started/rtl_backend_boxed/config.php
 *
 * Author: pixelcave
 *
 * Get Started RTL Backend Boxed configuration file
 *
 */

 // **************************************************************************************************
// INCLUDED VIEWS
// **************************************************************************************************

$one->inc_header                 = 'inc/get_started/rtl_backend_boxed/views/inc_header.php';
$one->inc_footer                 = 'inc/get_started/rtl_backend_boxed/views/inc_footer.php';


// **************************************************************************************************
// HEADER
// **************************************************************************************************

$one->l_header_dark              = true;
$one->l_header_fixed             = false;


// **************************************************************************************************
// MAIN CONTENT
// **************************************************************************************************

$one->l_m_content                = 'boxed';


// **************************************************************************************************
// RTL Support
// **************************************************************************************************

$one->l_rtl                      = true;


// **************************************************************************************************
// MAIN MENU
// **************************************************************************************************

$one->main_nav                   = array(
    array(
        'name'  => 'Dashboard',
        'icon'  => 'si si-speedometer',
        'url'   => 'gs_rtl_backend_boxed.php'
    ),
    array(
        'name'  => 'Heading',
        'type'  => 'heading'
    ),
    array(
        'name'  => 'Dropdown',
        'icon'  => 'si si-puzzle',
        'sub'   => array(
            array(
                'name'  => 'Link #1',
                'url'   => 'javascript:void(0)'
            ),
            array(
                'name'  => 'Link #2',
                'url'   => 'javascript:void(0)'
            )
        )
    )
);
