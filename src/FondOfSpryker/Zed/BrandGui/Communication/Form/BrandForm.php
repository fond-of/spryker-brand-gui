<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Form;

use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Required;

/**
 * @method \FondOfSpryker\Zed\BrandGui\BrandGuiConfig getConfig()
 * @method \FondOfSpryker\Zed\BrandGui\Communication\BrandGuiCommunicationFactory getFactory()
 */
class BrandForm extends AbstractType
{
    public const FIELD_BRAND_ID = 'id_brand';
    public const FIELD_NAME = 'name';
    public const FIELD_URL = 'url';
    public const FIELD_IS_ACTIVE = 'is_active';
    public const FIELD_LOGO_URL_SMALL = 'logo_url_small';
    public const FIELD_LOGO_URL_LARGE = 'logo_url_large';

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->addBrandIdField($builder)
            ->addNameField($builder)
            ->addUrlField($builder)
            ->addIsActiveField($builder)
            ->addLogoUrlSmallField($builder)
            ->addLogoUrlLargeField($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addBrandIdField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_BRAND_ID, HiddenType::class, [
            'label' => false,
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addNameField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_NAME, TextType::class, [
            'label' => 'Name',
            'constraints' => [
                new NotBlank(),
                new Required(),
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addUrlField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_URL, TextType::class, [
            'label' => 'Url',
            'required' => false,
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addIsActiveField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_IS_ACTIVE, CheckboxType::class, [
            'label' => 'Active',
            'required' => false,
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addLogoUrlSmallField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_LOGO_URL_SMALL, TextType::class, [
            'label' => 'Logo Url (Small)',
            'required' => false,
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addLogoUrlLargeField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_LOGO_URL_LARGE, TextType::class, [
            'label' => 'Logo Url (Large)',
            'required' => false,
        ]);

        return $this;
    }

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'brand';
    }

    /**
     * @deprecated Use `getBlockPrefix()` instead.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->getBlockPrefix();
    }
}
