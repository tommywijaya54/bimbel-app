import TextInput from '@/Shared/PageComponent/Field/InputField/TextInput';
import SelectInput from '@/Shared/PageComponent/Field/InputField/SelectInput';
import DataListInput from '@/Shared/PageComponent/Field/InputField/DataListInput';
import TextAreaInput from '@/Shared/PageComponent/Field/InputField/TextAreaInput';
import MultipleCheckboxInput from '@/Shared/PageComponent/Field/InputField/MultipleCheckboxInput';
import CurrencyInput from '@/Shared/PageComponent/Field/InputField/CurrencyInput';
import DataListMultipleValueInput from '@/Shared/PageComponent/Field/InputField/DataListMultipleValueInput';
import ValueField from './ValueField';

export default ({Field, data, setData, errors, nowrapper}) => {
    let {element, inputtype, entityname, label, className, required} = Field;

    if(element){
        return <ValueField nowrapper={nowrapper} field={Field}></ValueField>
    }

    let inputProps = { 
        label, 
        'name':entityname,
        'errors':errors[entityname],
        'value':data[entityname],
        'onChange':(e) => {setData(entityname, e.target.value)},
        'className':'w-full pb-8 pr-6 lg:w-1/2 '+className + (nowrapper ? ' no-label ' : ''),
        required,
        Field,
        ...Field.attr,
    }

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

    return (
        <TextInput {...inputProps} type={inputtype}/>
    )
}