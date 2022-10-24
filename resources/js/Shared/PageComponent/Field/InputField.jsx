import TextInput from '@/Shared/PageComponent/Field/InputField/TextInput';
import SelectInput from '@/Shared/PageComponent/Field/InputField/SelectInput';
import DataListInput from '@/Shared/PageComponent/Field/InputField/DataListInput';
import TextAreaInput from '@/Shared/PageComponent/Field/InputField/TextAreaInput';
import MultipleCheckboxInput from '@/Shared/PageComponent/Field/InputField/MultipleCheckboxInput';
import CurrencyInput from '@/Shared/PageComponent/Field/InputField/CurrencyInput';
import DataListMultipleValueInput from '@/Shared/PageComponent/Field/InputField/DataListMultipleValueInput';
import ValueField from './ValueField';
import { Children } from 'react';

const FieldWrapper = ({ label, name, className, children }) => {
  return (
    <div className={className}>
      {label && (
        <label className="form-label" htmlFor={name}>
          {label}:
        </label>
      )}
      {children}
    </div>
  );
};

const getField = ({inputProps, Field, data, setData, inputtype}) => {
    if(inputtype == 'select'){
        return (
            <SelectInput
                {...inputProps}
                options={Field.options}
            >
            </SelectInput>
        )
    }

    if(inputtype == 'datalist'){
        return <DataListInput
            {...inputProps}
            setData={setData}
            options={Field.options}
        />
    }
    
    if(inputtype == 'datalist-multiple-value'){
        return <DataListMultipleValueInput
            {...inputProps}
            setData={setData}
            options={Field.options}
        />
    }

    if(inputtype == 'multiple-checkbox'){
        return <MultipleCheckboxInput
            {...inputProps}
            setData={setData}
            data={data}
            className="w-full pb-8 pr-6"
        />
    }

    if(inputtype == 'textarea'){
        return <TextAreaInput
            {...inputProps}
        />
    }

    if(inputtype == 'currency'){
        return <CurrencyInput {...inputProps}  type={inputtype}/>
    }

    if(inputtype == 'date'){
        return <>
            <TextInput {...inputProps}  type={inputtype}/>
        </>
    }

    return (
        <TextInput {...inputProps} type={inputtype}/>
    )
}


export default ({Field, data, setData, errors, nowrapper}) => {
    let {element, inputtype, entityname, label, className, required} = Field;

    if(element){
        return <ValueField nowrapper={nowrapper} Field={Field}></ValueField>
    }
    let wrapperProps = {
        label,
        'name':entityname,
        'className':'w-full pb-8 pr-6 lg:w-1/2 '+className + (nowrapper ? ' no-label ' : '')
    }

    let inputProps = { 
        'name':entityname,
        'errors':errors[entityname],
        'value':data[entityname],
        'onChange':(e) => {setData(entityname, e.target.value)},
        required,
        Field,
        ...Field.attr,
    }

    let fieldProps = {
        inputProps, Field, data, setData, inputtype
    }

    return nowrapper ? 
        getField({...fieldProps}) : 
        <FieldWrapper {...wrapperProps}>{getField({...fieldProps})}</FieldWrapper> 
}