import TextInput from '@/Shared/TextInput';
import SelectInput from '@/Shared/SelectInput';
import DateInput from '@/Shared/DateInput';
import { FieldUtil } from '../../util_form';
export default ({Field, data, errors, setData}) => {
    if(Field.element){
        return FieldUtil.check_and_getCommonField(Field);
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