import React from "react";

export class FormSchema {
    constructor(form_schema){
        this.schema = {...form_schema};

        this.modal = this.schema.modal;
        this.id = this.schema.id;
        this.fields = this.schema.fields;
        
        this.display_form = this.schema.display_form;
        this.create_form = this.schema.create_form;
        this.edit_form = this.schema.edit_form;

        this.submit_url = this.schema.submit_url;
    }
    
    getValue(params){
        return this.fields.find(field => field.entityname == params).value;
    }

    getVariableForUseForm(){
        return this.fields.reduce((obj, item) => Object.assign(obj, { [item.entityname] : (item.value || '') }), {});
    }
}

export class FieldUtil{
    static check_and_getCommonField(field){
        if(field.element){
             if(field.element == 'row'){
                return React.createElement('div', {className:'row w-full'}, '');
                // return (<div key={keyId} className="blank-row w-full"></div>)
            }else if(field.element == 'line'){
                return React.createElement('div', {className:'line w-full'}, '');
                // return (<div key={keyId} className="line w-full"></div>)
            }
        }
        return null;
    }
}