<?php

namespace Dhii\Output;

use Exception as RootException;
use Dhii\Output\Exception\RendererException;
use Dhii\Output\Exception\CouldNotRenderException;
use Dhii\Util\String\StringableInterface as Stringable;

/**
 * Base concrete functionality for blocks.
 *
 * @since [*next-version*]
 */
abstract class AbstractBaseBlock extends AbstractBlock implements BlockInterface
{
    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _renderOnException(RootException $exception)
    {
        return $exception->__toString();
    }

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
     * Creates a new render failure exception.
     *
     * @since [*next-version*]
     *
     * @param string|Stringable|null $message  The error message, if any.
     * @param int|null               $code     The error code, if any.
     * @param RootException|null     $previous The inner exception for chaining, if any.
     *
     * @return CouldNotRenderException The new exception.
     */
    protected function _createCouldNotRenderException(
        $message = null,
        $code = null,
        RootException $previous = null
    ) {
        return new CouldNotRenderException($message, $code, $previous, $this);
    }
}
