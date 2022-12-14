import React from 'react';

export default ({
  name,
  errors = [],
  options,
  Field,
  ...props
}) => {
  return (
    <>
      <select
        id={name}
        name={name}
        {...props}
        className={`input-field form-select ${errors.length ? 'error' : ''}`}
      >
        <option value=''></option>
        {options.map((option, keyID) => {
            if(typeof option == 'string'){
                return  <option value={option} key={keyID}> {option} </option>
            }else if(typeof option == 'object'){
                return  <option value={option.id} key={keyID}>
                            {option.name}
                        </option>
            }
        })}
      </select>
      {errors && <div className="form-error">{errors}</div>}
    </>
  );
};
