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
 * Class BaseView
 *
 * @package ANXRI\api-framework
 */
abstract class BaseView
{
    protected string $lang;
    protected string $title;
    protected array $meta_data;
    protected array $styles;
    protected array $scripts;

    protected array $data;

    public function __construct()
    {
        $this->lang         = 'en';
        $this->title        = '';
        $this->meta_data    = [];
        $this->style_paths  = [];
        $this->script_paths = [];

        $this->data         = [];
    }

    abstract protected function header() : string;
    abstract protected function content() : string;
    abstract protected function footer() : string;

    final protected function set_meta_data( array $meta_data ) : void
    {
        foreach( $meta_data as $meta_elem )
            if( gettype( $meta_elem ) !== "array" )
                throw new \Exception( "In ".__CLASS__."::".__FUNCTION__." array of array expected. got array of ".gettype( $meta_elem )."|mixed." );

        $this->meta_data = $meta_data;
    }

    final protected function add_style_file( array $style_paths ) : void
    {
        foreach( $style_paths as $style_path )
            if( in_array( $style_path, $this->style_paths ))
                $this->style_paths[] = $style_path;
            else
                throw new \Exception( "In ".__CLASS__."::".__FUNCTION__." $style_path exists already." );
    }

    final protected function set_scripts( array $script_paths ) : void
    {
        foreach( $script_paths as $script_path )
            if( in_array( $script_path, $this->style_paths ))
                $this->script_paths[] = $script_path;
            else
                throw new \Exception( "In ".__CLASS__."::".__FUNCTION__." $script_path exists already." );
    }

    final protected function get_style_includes() : string
    {
        $link_tmpl = "<link rel=\"stylesheet\" type=\"text/css\" href=\"%%style_path%%\">\n";
        $style_includes = "";

        foreach( $this->style_paths as $style_path )
            $style_includes = str_replace( "%%style_path%%", $style_path, $link_tmpl );
    }

    final protected function get_script_includes() : string
    {
        $link_tmpl = "<script src=\"%%script_path%%\"></script>\n";
        $script_includes = "";

        foreach( $this->script_paths as $script_path )
            $script_includes = str_replace( "%%script_path%%", $script_path, $link_tmpl );
    }

    abstract public function __toString() : string;

    abstract public function print() : string;
}