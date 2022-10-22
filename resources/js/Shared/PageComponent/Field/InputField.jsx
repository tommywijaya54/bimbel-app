import TextInput from '@/Shared/TextInput';
import SelectInput from '@/Shared/SelectInput';
import DateInput from '@/Shared/DateInput';
import NumberInput from '@/Shared/NumberInput';
import DataListInput from '@/Shared/DataListInput';
import TextAreaInput from '@/Shared/TextAreaInput';
import MultipleCheckboxInput from '@/Shared/MultipleCheckboxInput';
import { FieldUtil } from '../../Util/Field_util';
import ValueField from './ValueField';
import CurrencyInput from '@/Shared/CurrencyInput';
import DataListMultipleValueInput from '@/Shared/DataListMultipleValueInput';

export default ({Field, data, setData, errors}) => {
    let {element, inputtype, entityname, label, className, required} = Field;

    if(element){
        return <ValueField field={Field}></ValueField>
    }

    let inputProps = { 
        label, 
        'name':entityname,
        'errors':errors[entityname],
        'value':data[entityname],
        'onChange':(e) => {setData(entityname, e.target.value)},
        'className':'w-full pb-8 pr-6 lg:w-1/2 '+className,
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