<?php

namespace Wehaa\AjaxCall;

use Laravel\Nova\Fields\Field;

class AjaxCall extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'ajax-call';

    public $link = '';

    public function resolve($resource, $attribute = null)
    {
        parent::resolve($resource, $attribute);

        $this->withMeta(
            [
                'link' => $this->link,
            ]
        );
    }

    public function link($link)
    {
        $this->link = $link;

        return $this;
    }
}
