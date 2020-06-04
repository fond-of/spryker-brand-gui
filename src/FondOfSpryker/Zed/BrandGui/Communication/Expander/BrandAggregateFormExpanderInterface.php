<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Expander;

use Symfony\Component\Form\FormBuilderInterface;

interface BrandAggregateFormExpanderInterface
{
    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return void
     */
    public function expandWithBrandAssignmentForms(FormBuilderInterface $builder): void;
}
