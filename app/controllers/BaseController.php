<?php

class BaseController extends Controller {

    /**
     * Default Layout
     *
     * @var string
     */
    protected $layout = 'start';

    /**
     * Desing params
     *
     * @var array
     */
    protected $params = array();

    /**
     * @param array|string $var
     * @param mixed $param
     * @return void
     */
    protected function addParam($var, $param = NULL)
    {
        if (is_array($var) && is_null($param)) {

            foreach ($var as $key => $value) {

                extract([$key => $value]);

                $this->params += compact($key);

                unset($$key);
            }

            unset($key);
            unset($value);

        } elseif(is_string($var)) {

            extract([$var => $param]);

            $this->params += compact($var);

            unset($$var);
        }
    }

    /**
     * @return object Report\Repositories\PageRepo
     */
    protected function getPage()
    {
        return (object) array(
            'app'         => 'apps.report',
            'description' => 'aCube - Call Center',
            'lang'        => 'es',
            'layout'      => 'layouts.default',
            'title'       => 'aCube - Call Center',
        );
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if ( ! is_null($this->layout))
        {
            if (empty($this->params)) {
                $this->addParam('page', $this->getPage());
            }
        }
    }

    /**
     * @return \View
     */
    protected function show()
    {
        return View::make($this->layout, $this->params);
    }

}
