import React, { useState } from 'react';

export default ({ label, name, className, errors = [], options, Field, ...props }) => {
  const handleFocus = (event) => event.target.select();
  const inputFieldRef = React.createRef();

  const [valueid, setValueid] = useState(Field.model_value.id);
  
  const dataListRef = React.createRef();
  const handleOnInput = (e) => {
    const val = e.target.value;
    const opts = dataListRef.current.childNodes;

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
        onInput={handleOnInput}
        
        ref={inputFieldRef}
        
        id={name}
        name={name}
        {...props}

        onFocus={handleFocus}
        className={`input-field form-input ${errors.length ? 'error' : ''}`}

        data-valueid={valueid}
      />
        <datalist id={name+'_list'} ref={dataListRef}>
            {options.map((option, keyId) => {
              return  <option key={keyId} data-valueid={option.id} value={option.name}></option>
            })}
        </datalist>
    
      {errors && <div className="form-error">{errors}</div>}
    </div>
  );
};
