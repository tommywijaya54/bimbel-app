import Component from "./Component"
import FormFooter from "./Footer"
import { FormSchema } from "../../Util/Form_util"

import React from 'react';
import DisplayForm from "./DisplayForm";
import CreateEditForm from "./CreateEditForm";

export default (form_schema) => {
    const {id, fields, modal, submit_url, form_type ,display_form, edit_form, create_form, form_note, children} = form_schema;
    const Form = new FormSchema(form_schema);

    window.Form = Form;

    let component_header = "No form type found";

    if(create_form){
        component_header = "Create "+Form.modal.cap()+" Form";
    }else if(display_form){
        component_header = 
        <>
            {Form.getValue('name') || Form.id}
            <span className="info">
                {Form.modal.cap() + ' Information'}
            </span>
        </>;
    }else if(edit_form){
        component_header = 
        <>
            {Form.getValue('name') || Form.id}
            <span className="info">
                Edit Form
            </span>
        </>;
    }

    return (<Component
                header={
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight">{component_header}</h2>
                }
                note={form_note}
                className={form_type+'-form'}
                footer={<FormFooter obj={{id:Form.id}} form={Form}></FormFooter>}
            >
                {Form.display_form && 
                    <DisplayForm fields={Form.fields}></DisplayForm>}
                
                {(Form.create_form || Form.edit_form)  && 
                    <CreateEditForm Form={Form}></CreateEditForm>}
        </Component>)
}





