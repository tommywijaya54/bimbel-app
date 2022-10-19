import React from 'react';
import { useForm } from '@inertiajs/inertia-react';
import LoadingButton from '@/Shared/LoadingButton';
import InputField from "../Field/InputField";

const CreateEditForm = ({Form, children}) => {
    const method = Form.edit_form ? {_method: 'PUT'} : null;
    const UseFormObject = {...Form.getVariableForUseForm(), ...method};
    const { data, setData, errors, post, processing, transform } = useForm(UseFormObject);
    
    transform((data) => {
        Form.fields.filter(f => f.model).forEach(field => {
            data[field.entityname] = document.getElementById(field.entityname).dataset.valueid;
        });
        
        Form.fields.filter(f => f.inputtype == 'currency').forEach(field => {
            if(typeof data[field.entityname] === 'string'){
                data[field.entityname] = data[field.entityname].replace(/\D/g, '');
            }
        });
        
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

                {children}

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

export default CreateEditForm;