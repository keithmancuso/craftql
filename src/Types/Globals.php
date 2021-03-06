<?php

namespace markhuot\CraftQL\Types;

use markhuot\CraftQL\Builders\Schema;

class Globals extends Schema {

    function getName():string {
        return ucfirst($this->context->handle);
    }

    protected function boot() {
        $this->addFieldsByLayoutId($this->context->fieldLayoutId);

        if (empty($this->fields)) {
            $warning = 'The global set, `'.$this->getName().'`, has no fields. This would violate the GraphQL spec so we filled it in with this placeholder.';
            $this->addStringField('empty')->description($warning)->resolve($warning);
        }
    }

    /**
     * Get the context used to create this schema
     *
     * return \craft\elements\GlobalSet
     */
    function getContext(): \craft\elements\GlobalSet {
        return parent::getContext();
    }

}