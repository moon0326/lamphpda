<?php

declare(strict_types=1);

namespace Marcosh\LamPHPda;

/**
 * @template A
 */
final class LinkedList
{
    /** @var bool */
    private $isNil;

    /**
     * @var mixed
     * @psalm-var A|null
     */
    private $head;

    /**
     * @var self|null
     * @psalm-var self<A>|null
     */
    private $tail;

    /**
     * @param bool $isNil
     * @param mixed $head
     * @psalm-param A|null $head
     * @param self|null $tail
     * @psalm-param self<A>|null $tail
     */
    private function __construct(bool $isNil, $head = null, self $tail = null)
    {
        $this->isNil = $isNil;
        $this->head = $head;
        $this->tail = $tail;
    }

    /**
     * @template B
     * @psalm-return self<B>
     */
    public static function empty(): self
    {
        return new self(true);
    }

    /**
     * @template B
     * @param mixed $head
     * @psalm-param B $head
     * @param self $tail
     * @psalm-param self<B> $tail
     * @return self
     * @psalm-return self<B>
     */
    public static function cons($head, self $tail): self
    {
        return new self(false, $head, $tail);
    }

    /**
     * @template B
     * @template C
     * @param callable $op
     * @psalm-param callable(B, C): C $op
     * @param mixed $unit
     * @psalm-param C $unit
     * @return mixed
     * @psalm-return C
     */
    public function foldr(callable $op, $unit)
    {
        if ($this->isNil) {
            return $unit;
        }

        /**
         * @psalm-suppress PossiblyInvalidArgument
         * @psalm-suppress PossiblyNullReference
         */
        return $op($this->head, $this->tail->foldr($op, $unit));
    }
}
