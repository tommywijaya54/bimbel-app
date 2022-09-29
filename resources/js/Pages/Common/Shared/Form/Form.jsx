import Component from "./Component"
import FormFooter from "./Footer"
import { FormSchema } from "../util_form"

import React from 'react';
import { useForm } from '@inertiajs/inertia-react';
import LoadingButton from '@/Shared/LoadingButton';
import InputField from "./Field/InputField";
import DisplayField from "./Field/DisplayField";

const CreateEditForm = ({Form}) => {
    const method = Form.edit_form ? {_method: 'PUT'} : null;
    const UseFormObject = {...Form.getVariableForUseForm(), ...method};
    const { data, setData, errors, post, processing, transform } = useForm(UseFormObject);

    window.tomatoDebugger = {
        form : Form,
        setData : setData
    }
    
    window.data = data;
    window.setData = setData;

    transform((data) => {
        Form.fields.filter(f => f.model).forEach(y => data[y.entityname] =  data[y.entityname].split(" : ")[0]);
        return data;
    })

    function handleSubmit(e) {
        e.preventDefault();
        post(Form.submit_url);
    }

    return <div className="w-full">
            <form onSubmit={handleSubmit}>
                <div className="flex flex-wrap p-6 -mb-8 -mr-6">
                    {Form.fields.map((Field, keyId) => {
                        return <InputField 
                            Field={Field} 
                            key={keyId}
                            errors={errors}
                            data={data}
                            setData={setData}    
                        ></InputField>
                    })}
                </div>

                <div className="flex items-center px-8 py-4 bg-gray-100 border-t border-gray-200">
                    <LoadingButton
                        loading={processing}
                        type="submit"
                        className="ml-auto btn-indigo"
                    >
                        Save
                    </LoadingButton>
                </div>
            </form>
        </div>
}

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
                {Form.display_form && <DisplayField fields={Form.fields} form={Form}></DisplayField>}
                
                {(Form.create_form || Form.edit_form)  && <CreateEditForm Form={Form}></CreateEditForm>}
            {children}
        </Component>)
}





