export class FormSchema {
    constructor(form_schema){
        this.schema = {...form_schema};

        this.modal = this.schema.modal;
        this.id = this.schema.id;
        this.fields = this.schema.fields;

        this.fields_has_entity = this.fields.filter(field => {
            return field.entityname
        });
        
        this.display_form = this.schema.display_form;
        this.create_form = this.schema.create_form;
        this.edit_form = this.schema.edit_form;

        this.submit_url = this.schema.submit_url;
    }
    
    getValue(params){
        return this.fields_has_entity.find(field => field.entityname == params)?.value;
    }

    getVariableForUseForm(){
        return this.fields.reduce((obj, item) => Object.assign(obj, { [item.entityname] : (item.value || '') }), {});
    }
}
