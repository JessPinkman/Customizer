<?php

namespace Customizer;

use WP_Customize_Color_Control;
use WP_Customize_Control;
use WP_Customize_Manager;
use WP_Customize_Media_Control;
use WP_Customize_Section;

class Section extends WP_Customize_Section
{

    private $origin_panel;

    public function __construct(WP_Customize_Manager $manager, Panel $panel, string $id, $args)
    {
        $this->origin_panel = $panel;
        parent::__construct($manager, $id, $args);
        $manager->add_section($this);
    }

    public function control(string $id, array $args = [], $default = null): self
    {
        $this->addSetting($id, $default);
        $args['section'] = $this->id;
        $this->registerControl(new WP_Customize_Control($this->manager, $id, $args));
        return $this;
    }

    private function addSetting($id, $default): void
    {
        $this->manager->add_setting($id, [
            'type'          => 'theme_mod',
            'capability'    => 'edit_theme_options',
            'transport'     => 'refresh',
            'default'       => $default,
        ]);
    }

    private function registerControl(WP_Customize_Control $control): void
    {
        $this->manager->add_control($control);
    }

    public function media(string $type, string $id, string $label): self
    {
        $this->addSetting($id, null);
        $this->registerControl(new WP_Customize_Media_Control($this->manager, $id, [
            'section'   => $this->id,
            'label'     => $label,
            'mime_type' => $type
        ]));
        return $this;
    }

    public function color(string $id, string $label, string $default = null): self
    {
        $this->addSetting($id, $default);
        $this->registerControl(new WP_Customize_Color_Control($this->manager, $id, [
            'label'     => $label,
            'section'   => $this->id,
        ]));
        return $this;
    }

    public function section(string $id, string $title): self
    {
        return new self($this->manager, $this->origin_panel, $id, [
            'title' => $title,
            'panel' => $this->origin_panel->id,
        ]);
    }
}
