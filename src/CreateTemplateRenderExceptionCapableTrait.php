<?php

namespace Dhii\Output;

use Dhii\Util\String\StringableInterface as Stringable;
use Exception as RootException;
use Dhii\Output\Exception\TemplateRenderException;
use Psr\Container\ContainerInterface;

trait CreateTemplateRenderExceptionCapableTrait
{
    /**
     * Creates a new render failure exception.
     *
     * @since [*next-version*]
     *
     * @param string|Stringable|null  $message  The error message, if any.
     * @param int|null                $code     The error code, if any.
     * @param RootException|null      $previous The inner exception for chaining, if any.
     * @param TemplateInterface|null  $template The associated renderer, if any.
     * @param ContainerInterface|null $context  The associated context, if any.
     *
     * @return TemplateRenderException The new exception.
     */
    protected function _createTemplateRenderException(
        $message = null,
        $code = null,
        RootException $previous = null,
        TemplateInterface $template = null,
        ContainerInterface $context = null
    ) {
        return new TemplateRenderException($message, $code, $previous, $template, $context);
    }
}
