import React, { useState } from 'react';

export default ({ label, name, className, errors = [], options, Field, ...props }) => {
  const handleFocus = (event) => event.target.select();
  const [valueid, setValueid] = useState(Field.model_value?.id || null);
  
  const handleOnInput = (e) => {
    const val = e.target.value;
    const opts = e.target.list.childNodes; 
    setValueid('');
    for (var i = 0; i < opts.length; i++) {
      if (opts[i].value === val) {
        setValueid(opts[i].dataset.valueid);
        break;
      }
    }
  }

  return (
    <div className={className}>
      {label && (
        <label className="form-label" htmlFor={name}>
          {label}:
        </label>
      )}

      <input
        list={name+'_list'}
        data-valueid={valueid}

        id={name}
        name={name}

        {...props}

        onFocus={handleFocus}
        onInput={handleOnInput}

        className={`input-field form-input ${errors.length ? 'error' : ''}`}        
      />
        <datalist id={name+'_list'} >
            {options.map((option, keyId) => {
              return  <option key={keyId} data-valueid={option.id} value={option.name}></option>
            })}
        </datalist>
    
      {errors && <div className="form-error">{errors}</div>}
    </div>
  );
};
