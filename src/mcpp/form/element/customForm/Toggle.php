<?php

namespace mcpp\form\element\customForm;

use mcpp\form\element\FormElement;

class Toggle extends FormElement
{
    /** @var boolean */
    protected $defaultValue = false;

    /**
     *
     * @param string $text
     * @param bool $value
     */
    public function __construct($text, bool $value = false)
    {
        $this->text = $text;
        $this->defaultValue = $value;
    }

    /**
     *
     * @param bool $value
     */
    public function setDefaultValue(bool $value)
    {
        $this->defaultValue = $value;
    }

    /**
     *
     * @return array
     */
    final public function getDataToJson()
    {
        return [
            "type" => "toggle",
            "text" => $this->text,
            "default" => $this->defaultValue
        ];
    }

    public function handle($value, $player)
    {
    }
}
