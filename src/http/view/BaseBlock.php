<?php
/*
 * Copyright (c) 2020 Dejan Horakovic
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the
 * Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS
 * OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
 * OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 */

namespace ANXRI\Base;

/**
 * Class BaseBlock
 *
 * @package ANXRI\util
 */
abstract class BaseBlock
{
    protected array $data;
    protected string $html_tag;

    protected array $attributes;    // has to match a defined array structure:
                                    // $attributes[<attribute_name:string>][<attribute_value:int{n>0}>]

    /**
     * BaseBlock constructor.
     *
     * @param array  $data
     * @param string $html_tag
     * @param array  $attributes
     */
    public function __construct(
        array $data=[],
        string $html_tag="div",
        array $attributes=[]
    )
    {
        $this->data         = $data;
        $this->html_tag     = $html_tag;
        $this->attributes   = $attributes;
    }

    /**
     * construct html attributes (<div [id="some-id another-id"]></div>)
     *
     * @param string $attribute_name
     * @param array  $attributes
     *
     * @return string
     */
    private function construct_html_attributes( string $attribute_name, array $attributes ) : string
    {
        $html_attributes    = "";

        if( isset_not_empty( $attributes ))
            foreach( $attributes as $key => $attribute )
                $html_attributes .= $attribute.( $key !== array_key_last( $attributes ) ? " " : "" );

        return "$attribute_name=\"$html_attributes\"";
    }

    /**
     * @return string
     */
    final protected function get_open_tag() : string
    {
        $open_tag = "<$this->html_tag ";

        foreach( array_keys( $this->attributes ) as $attribute_names )
            $open_tag .= $this->construct_html_attributes( $this->attributes[$attribute_names] )." ";

        $open_tag .= ">";
        return $open_tag;
    }

    /**
     * @return string
     */
    final protected function get_close_tag() : string
    {
        return "</$this->attributes>";
    }

    /**
     * @return string
     */
    abstract public function __toString() : string;

    /**
     * @return string
     */
    abstract public function print() : string;
}