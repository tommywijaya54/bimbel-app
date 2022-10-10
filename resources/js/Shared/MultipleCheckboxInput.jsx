import { useState } from 'react';

const MultipleCheckboxInput = ({field, label, name, className,setData, errors = [], ...props }) => {
    const [fieldValue, setFieldValue] = useState([...field.value]);

    const handleChange = (e) => {
        let value = e.target.value;
        if (e.target.checked) {
            setData(field.entityname, [...data[field.entityname], value]);
            setFieldValue([...data[field.entityname], value]);
        } else {
            const values = data[field.entityname].filter((item) =>  item !== value);
            setData(field.entityname,values);
            setFieldValue(values);
        }
    }

    if(field.special_request == "group-the-options"){
        field.groupedOptions = field.options.reduce((group, permission) => {
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
    <div className={className}>
        {label && (
            <label className="form-label" htmlFor={name}>
            {label}:
            </label>
        )}
        {field.groupedOptions &&
        <table>
            <tbody>
                {Object.keys(field.groupedOptions).map((propertyKey, keyid)=>{
                    return (
                        <tr key={keyid} className='hover:bg-gray-100 focus-within:bg-gray-100'>
                            <td className='p-2'><strong className='pr-6'>{propertyKey.cap()}</strong></td>
                            {
                                field.groupedOptions[propertyKey].map((option, keyId) => {
                                    return (
                                        <td key={keyId}>
                                        <label  className="pr-6 check-box">
                                            <input type="checkbox" 
                                                name={field.entityname} 
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

        {!field.groupedOptions && field.options.map((option, index) => {
            return (
                <label  className="pr-6 check-box" key={index}>
                    <input type="checkbox" 
                        name={field.entityname} 
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
    </div>
  );
};

export default MultipleCheckboxInput;