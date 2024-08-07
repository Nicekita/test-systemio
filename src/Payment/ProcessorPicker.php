<?php
declare(strict_types=1);

namespace App\Payment;

use Exception;


class ProcessorPicker
{

    public function __construct(private iterable $processors
    )
    {
    }

    /**
     * Эту ошибку не надо ловить, т.к. валидация не должна пустить сюда некорректный процессор
     * @throws Exception
     */
    public function pickProcessor(string $processor): PaymentProcessor
    {
        $processors = $this->getProcessorArray();

        return $processors[$processor] ?? throw new Exception('This payment method is not implemented yet.');
    }

    public function getAvailableProcessors(): array
    {
        return array_keys($this->getProcessorArray());
    }


    private function getProcessorArray(): array
    {
        return $this->processors instanceof \Traversable ? iterator_to_array($this->processors) : [];
    }
}