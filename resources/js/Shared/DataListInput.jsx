import React from 'react';

export default ({ label, name, className, errors = [], options, ...props }) => {
  return (
    <div className={className}>
      {label && (
        <label className="form-label" htmlFor={name}>
          {label}:
        </label>
      )}
      <input
        list={name+'_list'}
        id={name}
        name={name}
        {...props}
        className={`input-field form-input ${errors.length ? 'error' : ''}`}
      />
        <datalist id={name+'_list'}>
            {options.map((value, keyId) => {
              return  <option key={keyId} value={value.id+" : "+value.name}>{value.id+" : "+value.name}</option>
            })}
        </datalist>
    
      {errors && <div className="form-error">{errors}</div>}
    </div>
  );
};
