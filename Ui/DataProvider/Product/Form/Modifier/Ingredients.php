<?php


namespace Ngoc\Ingredient\Ui\DataProvider\Product\Form\Modifier;


use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Framework\Stdlib\ArrayManager;

class Ingredients extends AbstractModifier
{
    /**
     * @var LocatorInterface
     */
    protected $locator;

    /**
     * @var ArrayManager
     */
    protected $arrayManager;

    /**
     * @param LocatorInterface $locator
     * @param ArrayManager $arrayManager
     */
    public function __construct(
        LocatorInterface $locator,
        ArrayManager $arrayManager
    ) {
        $this->locator = $locator;
        $this->arrayManager = $arrayManager;
    }
    /**
     * @inheritDoc
     */
    public function modifyData(array $data)
    {
        return $data;
    }

    /**
     * @inheritDoc
     */
    public function modifyMeta(array $meta)
    {
        $meta = $this->customizeIngredientsField($meta);
        return $meta;
    }

    protected function customizeIngredientsField(array $meta)
    {
        $fieldCode = 'ingredient';
        $elementPath = $this->arrayManager->findPath($fieldCode, $meta, null, 'children');
        $containerPath = $this->arrayManager->findPath(static::CONTAINER_PREFIX . $fieldCode, $meta, null, 'children');
        $fieldIsDisabled = $this->locator->getProduct()->isLockedAttribute($fieldCode);

        if (!$elementPath) {
            return $meta;
        }

        $value = [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => false,
                        'required' => false,
                        'dataScope' => '',
                        'breakLine' => false,
                        'formElement' => 'container',
                        'componentType' => 'container',
                        'component' => 'Magento_Ui/js/form/components/group',
                        'disabled' => $this->locator->getProduct()->isLockedAttribute($fieldCode),
                    ],
                ],
            ],
            'children' => [
                $fieldCode => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'formElement' => 'select',
                                'componentType' => 'field',
                                'component' => 'Ngoc_Ingredient/js/components/ingredients',
                                'filterOptions' => true,
                                'disableLabel' => true,
                                'levelsVisibility' => '1',
                                'disabled' => $fieldIsDisabled,
                                'isRemoveSelectedIcon' => true,
                                'elementTmpl' => 'ui/grid/filters/elements/ui-select',
                                'config' => [
                                    'dataScope' => $fieldCode
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ];

        return $this->arrayManager->merge($containerPath, $meta, $value);
    }
}