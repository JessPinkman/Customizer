<?php

namespace Customizer;

use WP_Customize_Manager;

class Customizer
{
    public function __construct(WP_Customize_Manager $wp_customizer_manager)
    {
        $this->manager = $wp_customizer_manager;
    }

    public function panel($id, $title): Panel
    {
        return new Panel($this->manager, $id, ['title' => $title]);
    }
}
