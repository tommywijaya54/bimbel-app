import TextInput from '@/Shared/TextInput';
import SelectInput from '@/Shared/SelectInput';
import DateInput from '@/Shared/DateInput';
import NumberInput from '@/Shared/NumberInput';
import DataListInput from '@/Shared/DataListInput';
import TextAreaInput from '@/Shared/TextAreaInput';
import MultipleCheckboxInput from '@/Shared/MultipleCheckboxInput';
import { FieldUtil } from '../../Util/Field_util';
import ValueField from './ValueField';

export default ({Field, data, errors, setData}) => {
    let {element, inputtype, entityname, label, className} = Field;

    if(element){
        return <ValueField Field={Field}></ValueField>
        // return FieldUtil.getElementIfExist(Field);
    }

    let inputProps = { 
        label, 
        'name':entityname,
        'errors':errors[entityname],
        'value':data[entityname],
        'onChange':(e) => {setData(entityname, e.target.value)},
        'className':'w-full pb-8 pr-6 lg:w-1/2 '+className,
        Field
    }

    if(inputtype == 'select'){
        return (
            <SelectInput
                {...inputProps}
            >
                <option value=''></option>
                {Field.options.map((option, keyID) => {
                    if(typeof option == 'string'){
                        return  <option value={option} key={keyID}> {option} </option>
                    }else if(typeof option == 'object'){
                        return  <option value={option.id} key={keyID}>
                                    {option.name}
                                </option>
                    }
                })}
            </SelectInput>
        )
    }

    if(inputtype == 'datalist'){
        return <DataListInput
            {...inputProps}
            options={Field.options}
        />
    }

    if(inputtype == 'multiple-checkbox'){
        
        return <MultipleCheckboxInput
            {...inputProps}
            setData={setData}
            data={data}
            className="w-full pb-8 pr-6"
        >
        </MultipleCheckboxInput>
    }

    if(inputtype == 'textarea'){
        return <TextAreaInput
            {...inputProps}
            
        />
    }

    
    /*
    if(inputtype == 'date'){
        return <DateInput {...inputProps} />
    }

    if(inputtype == 'number'){
        return <NumberInput {...inputProps} />
    }*/

    return (
        <TextInput {...inputProps} type={Field.inputtype}/>
    )
}