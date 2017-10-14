<?php

namespace Dhii\Output;

use Exception as RootException;
use Dhii\Output\Exception\RendererException;
use Dhii\Output\Exception\TemplateRenderException;
use Dhii\Util\String\StringableInterface as Stringable;
use Dhii\I18n\StringTranslatingTrait;
use Dhii\Exception\CreateInvalidArgumentExceptionCapableTrait;

/**
 * Base concrete functionality for templates.
 *
 * @since [*next-version*]
 */
abstract class AbstractBaseTemplate extends AbstractTemplate implements TemplateInterface
{
    /*
     * Adds internal i18n capabilities.
     *
     * @since [*next-version*]
     */
    use StringTranslatingTrait;

    /*
     * Adds internal factory for creating invalid argument exceptions.
     *
     * @since [*next-version*]
     */
    use CreateInvalidArgumentExceptionCapableTrait;

    /**
     * Creates a new render-related exception.
     *
     * @since [*next-version*]
     *
     * @param string|Stringable|null $message  The error message, if any.
     * @param int|null               $code     The error code, if any.
     * @param RootException|null     $previous The inner exception for chaining, if any.
     *
     * @return RendererException The new exception.
     */
    protected function _createRendererException(
        $message = null,
        $code = null,
        RootException $previous = null
    ) {
        return new RendererException($message, $code, $previous, $this);
    }

    /**
     * Creates a new template rendering exception.
     *
     * @since [*next-version*]
     *
     * @param string|Stringable  $message  The error message, if any.
     * @param int|null           $code     The error code, if any.
     * @param RootException|null $previous The inner exception, if any.
     * @param mixed|null         $context  The rendering context, if any.
     *
     * @return TemplateRenderException The new exception.
     */
    protected function _createTemplateException(
        $message = null,
        $code = null,
        RootException $previous = null,
        $context = null
    ) {
        return new TemplateRenderException($message, $code, $previous, $this, $context);
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function render($context = null)
    {
        return $this->_render($context);
    }
}
