
import React from 'react';
import { useForm } from '@inertiajs/inertia-react';
import LoadingButton from '@/Shared/LoadingButton';
import FormElement from './FormElement';
import { FormObject } from '@/util';

const EditForm = ({props}) => {
    const FormOb = new FormObject(props.form_fields,props.data,props.form_fields_options);
    const { data, setData, errors, post, processing } = useForm({
        ...FormOb.Object,
        _method: 'PUT'
    });
    
  function handleSubmit(e) {
    e.preventDefault();
    post(props.post_url);
  }

  return <>
            <form onSubmit={handleSubmit}>
                <div className="flex flex-wrap p-8 -mb-8 -mr-6">
                    {FormOb.DisplayElementInArray.map((Element, keyId) => {
                        return <FormElement 
                            Element={Element} 
                            key={keyId}
                            errors={errors}
                            data={data}
                            setData={setData}    
                        ></FormElement>
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
        </>
}

export default EditForm;