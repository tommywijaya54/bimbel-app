import { useState } from 'react';

const MultipleCheckboxInput = ({Field, name, data, setData, errors = [], ...props }) => {
    const [fieldValue, setFieldValue] = useState([...Field.value]);

    const handleChange = (e) => {
        let value = e.target.value;
        if (e.target.checked) {
            setData(Field.entityname, [...data[Field.entityname], value]);
            setFieldValue([...data[Field.entityname], value]);
        } else {
            const values = data[Field.entityname].filter((item) =>  item !== value);
            setData(Field.entityname,values);
            setFieldValue(values);
        }
    }

    if(Field.special_request == "group-the-options"){
        Field.groupedOptions = Field.options.reduce((group, permission) => {
            const group_name = permission.split("-")[1];
            group[group_name] = group[group_name] ?? [];
            group[group_name].push(permission);
            return group;
        }, {});
    }

    function checkState(permission){
        return !!fieldValue.find(p => p === permission);
    }

    return (
    <>
        {Field.groupedOptions &&
        <table>
            <tbody>
                {Object.keys(Field.groupedOptions).map((propertyKey, keyid)=>{
                    return (
                        <tr key={keyid} className='hover:bg-gray-100 focus-within:bg-gray-100'>
                            <td className='p-2'><strong className='pr-6'>{propertyKey.cap()}</strong></td>
                            {
                                Field.groupedOptions[propertyKey].map((option, keyId) => {
                                    return (
                                        <td key={keyId}>
                                        <label  className="pr-6 check-box">
                                            <input type="checkbox" 
                                                name={Field.entityname} 
                                                value={option} 
                                                onChange={handleChange} 
                                                checked={checkState(option)}
                                                />
                                            <span className="ml-2 text-sm text-indigo-600">
                                                    {option}
                                            </span>
                                        </label>
                                        </td>
                                    );
                                })
                            }
                        </tr>
                    )
                })}
            </tbody>
        </table>
        }

        {!Field.groupedOptions && Field.options.map((option, index) => {
            return (
                <label  className="pr-6 check-box" key={index}>
                    <input type="checkbox" 
                        name={Field.entityname} 
                        value={option} 
                        onChange={handleChange} 
                        checked={checkState(option)}
                        />
                    <span className="ml-2 text-sm text-indigo-600">
                            {option}
                    </span>
                </label>
            );
        })}

      {errors && <div className="form-error">{errors}</div>}
    </>
  );
};

export default MultipleCheckboxInput;