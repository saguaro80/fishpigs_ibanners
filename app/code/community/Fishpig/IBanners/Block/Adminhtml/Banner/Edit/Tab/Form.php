<?php
/**
 * @category    Fishpig
 * @package     Fishpig_iBanners
 * @license     http://fishpig.co.uk/license.txt
 * @author      Ben Tideswell <help@fishpig.co.uk>
 */

class Fishpig_iBanners_Block_Adminhtml_Banner_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Retrieve Additional Element Types
     *
     * @return array
    */
    protected function _getAdditionalElementTypes()
    {
        return array(
                'image' => Mage::getConfig()->getBlockClassName('ibanners/adminhtml_banner_helper_image'),
                'image_mobile' => Mage::getConfig()->getBlockClassName('ibanners/adminhtml_banner_helper_image')
        );
    }

    /**
     * Prepare the banner form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $editor = (Mage::getStoreConfig('cms/wysiwyg/enabled') == 'disabled') ? false : true;

        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('banner_');
        $form->setFieldNameSuffix('banner');

        $this->setForm($form);

        $fieldset = $form->addFieldset('banner_general', array(
            'legend'=> $this->__('General Information'),
            'class' => 'fieldset-wide',
        ));

        $this->_addElementTypes($fieldset);

        $fieldset->addField('group_id', 'select', array(
            'name'          => 'group_id',
            'label'         => $this->__('Group'),
            'title'         => $this->__('Group'),
            'required'      => true,
            'class'         => 'required-entry',
            'values'        => $this->_getGroups()
        ));

        $fieldset->addField('title', 'text', array(
            'name'      => 'title',
            'label' 	=> $this->__('Title'),
            'title' 	=> $this->__('Title'),
            'required'	=> true,
            'class'     => 'required-entry',
        ));

        $fieldset->addField('subtitle', 'text', array(
            'name'      => 'subtitle',
            'label'     => $this->__('Subtitle'),
            'title'     => $this->__('Subtitle'),
            'required'  => false,
        ));
        
        $fieldset->addField('text', 'text', array(
            'name' => 'text',
            'label' => $this->__('Presentation Text'),
            'title' => $this->__('Presentation Text'),
        ));
        
        $fieldset->addField('button_text', 'text', array(
            'name'=> 'button_text',
            'label' => $this->__('Button Label'),
            'title' => $this->__('Button Label')
        ));
        
        $fieldset->addField('url', 'text', array(
            'name'      => 'url',
            'label' 	=> $this->__('URL'),
            'title' 	=> $this->__('URL')
        ));

        $fieldset->addField('category', 'select', array(
            'name' => 'category',
            'label' => $this->__('Category Url'),
            'title' => $this->__('Category Url'),
            'values' => $this->getAllCategoriesArray()
        ));

        $fieldset->addField('image', 'image', array(
            'name' 	=> 'image',
            'label' 	=> $this->__('Image'),
            'title' 	=> $this->__('Image'),
            'required'	=> true,
            'class'	=> 'required-entry',
        ));

        $fieldset->addField('image_mobile', 'image_mobile', array(
            'name'      => 'image_mobile',
            'label'     => $this->__('Image Mobile'),
            'title'     => $this->__('Image Mobile'),
            'required'  => true,
            'class'     => 'required-entry'
        ));
        
        $fieldset->addField('sort_order', 'text', array(
            'name' 	=> 'sort_order',
            'label' 	=> $this->__('Sort Order'),
            'title' 	=> $this->__('Sort Order'),
            'class'	=> 'validate-digits',
        ));

        $fieldset->addField('is_enabled', 'select', array(
            'name'      => 'is_enabled',
            'title'     => $this->__('Enabled'),
            'label'     => $this->__('Enabled'),
            'required'  => true,
            'values'    => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(),
        ));

        if ($banner = Mage::registry('ibanners_banner')) {
                $form->setValues($banner->getData());
        }

        return parent::_prepareForm();
    }

    /**
     * Retrieve an array of all of the stores
     *
     * @return array
     */
    protected function _getGroups()
    {
        $groups = Mage::getResourceModel('ibanners/group_collection');
        $options = array('' => $this->__('-- Please Select --'));

        foreach($groups as $group) {
            $options[$group->getId()] = $group->getTitle();
        }

        return $options;
    }
    
    protected function getAllCategoriesArray()
    {
        $categoriesArray = Mage::getModel('catalog/category')
            ->getCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('url_path')
            ->addAttributeToSort('path', 'asc')
            ->addFieldToFilter('is_active', array('eq'=>'1'))
            ->load()
            ->toArray();

        $categories = array();
        $categories[] = array(
            'value' => '',
            'label' => $this->__('-- Select a Category --')
        );
        
        foreach ($categoriesArray as $categoryId => $category) {
            if (isset($category['name'])) {
                $categories[] = array(
                    'value' => $category['entity_id'],
                    'label' => $category['name']
                );
            }
        }
        
        return $categories;
    }
}
