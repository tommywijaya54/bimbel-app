import TextInput from '@/Shared/TextInput';
import SelectInput from '@/Shared/SelectInput';
import DateInput from './DateInput';

export default ({Element, data, errors, setData}) => {
    if(Element.element == "row"){
        return (
            <div key={keyId} class="w-full pb-8 pr-6 lg:w-1/2"></div>
        )
    }

    if(Element.options){
        return (
            <SelectInput
                className="w-full pb-8 pr-6 lg:w-1/2"
                label={Element.label}
                name={Element.entityname}
                errors={errors[Element.entityname]}
                value={data[Element.entityname]}
                onChange={e => setData(Element.entityname, e.target.value)}
            >
                {Element.options.map((option, keyID) => {
                    return <option value={option} key={keyID}>
                        {option}
                    </option>
                })}
            </SelectInput>
        )
    }

    if(Element.entityname.includes('_date')){
        return <DateInput
            className="w-full pb-8 pr-6 lg:w-1/2"
            label={Element.label}
            name={Element.entityname}
            errors={errors[Element.entityname]}
            value={data[Element.entityname]}
            onChange={e => setData(Element.entityname, e.target.value)}
        />
    }

    return (
        <TextInput
            className="w-full pb-8 pr-6 lg:w-1/2"
            label={Element.label}
            name={Element.entityname}
            errors={errors[Element.entityname]}
            value={data[Element.entityname]}
            onChange={e => setData(Element.entityname, e.target.value)}
        />
    )
}