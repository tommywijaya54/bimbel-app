import TextInput from '@/Shared/TextInput';
import SelectInput from '@/Shared/SelectInput';
import DateInput from '@/Shared/DateInput';
import NumberInput from '@/Shared/NumberInput';
import DataListInput from '@/Shared/DataListInput';
import TextAreaInput from '@/Shared/TextAreaInput';
import MultipleCheckboxInput from '@/Shared/MultipleCheckboxInput';
import { FieldUtil } from '../../Util/Field_util';

export default ({Field, data, errors, setData}) => {
    if(Field.element){
        return FieldUtil.getElementIfExist(Field);
    }

    if(Field.inputtype == 'select'){
        return (
            <SelectInput
                className="w-full pb-8 pr-6 lg:w-1/2"
                label={Field.label}
                name={Field.entityname}
                errors={errors[Field.entityname]}
                value={data[Field.entityname]}
                onChange={e => setData(Field.entityname, e.target.value)}
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

    if(Field.inputtype == 'datalist'){
        return <DataListInput
            className="w-full pb-8 pr-6 lg:w-1/2"
            label={Field.label}
            name={Field.entityname}
            errors={errors[Field.entityname]}
            value={data[Field.entityname]}
            onChange={e => setData(Field.entityname, e.target.value)}
            options={Field.options}
            Field={Field}
        />
    }

    if(Field.inputtype == 'multiple-checkbox'){
        return <MultipleCheckboxInput
            field={Field}
            setData={setData}
            className="w-full pb-8 pr-6"
            label={Field.label}
            name={Field.entityname}
            errors={errors[Field.entityname]}
        ></MultipleCheckboxInput>
    }

    if(Field.inputtype == 'textarea'){
        return <TextAreaInput
            className="w-full pb-8 pr-6 lg:w-1/2"
            label={Field.label}
            name={Field.entityname}
            errors={errors[Field.entityname]}
            value={data[Field.entityname]}
            onChange={e => setData(Field.entityname, e.target.value)}
        />
    }


    if(Field.inputtype == 'date'){
        return <DateInput
            className="w-full pb-8 pr-6 lg:w-1/2"
            label={Field.label}
            name={Field.entityname}
            errors={errors[Field.entityname]}
            value={data[Field.entityname]}
            onChange={e => setData(Field.entityname, e.target.value)}
        />
    }

    if(Field.inputtype == 'number'){
        return <NumberInput
            className="w-full pb-8 pr-6 lg:w-1/2"
            step="100000"
            label={Field.label}
            name={Field.entityname}
            errors={errors[Field.entityname]}
            value={data[Field.entityname]}
            onChange={e => setData(Field.entityname, e.target.value)}
        />
    }

    return (
        <TextInput
            className="w-full pb-8 pr-6 lg:w-1/2"
            label={Field.label}
            name={Field.entityname}
            errors={errors[Field.entityname]}
            value={data[Field.entityname]}
            onChange={e => setData(Field.entityname, e.target.value)}
        />
    )
}