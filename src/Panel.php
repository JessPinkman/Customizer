<?php

namespace Customizer;

use WP_Customize_Manager;
use WP_Customize_Panel;

class Panel extends WP_Customize_Panel
{

    public function __construct(WP_Customize_Manager $manager, string $id, $args = [])
    {
        parent::__construct($manager, $id, $args);
        $manager->add_panel($this);
    }

    public function section(string $id, string $title): Section
    {
        return new Section($this->manager, $this, $id, [
            'title' => $title,
            'panel' => $this->id
        ]);
    }
}
