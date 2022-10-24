import React, { useEffect, useState } from 'react';

export default ({name, errors = [], options, Field, setData, onChange, value, required, ...props }) => {
  const handleFocus = (event) => event.target.select();
  const [valueid, setValueid] = useState(Field.model_value?.id || '');
  const [inputboxValue, setInputboxValue] = useState(Field.model_value?.name || '');
  
  const handleOnInput = (e) => {
    const val = e.target.value;
    const opts = e.target.list.childNodes; 
    setValueid('');
    setData(name,'');
    for (var i = 0; i < opts.length; i++) {
      if (opts[i].value === val) {
        const val = opts[i].dataset.valueid;
        setValueid(val);
        setData(name,val);
        break;
      }
    }
  }

  return (
    <>
       <input
          type="hidden"
          id={name}
          name={name}
          value={valueid}
          {...props}
          />

      <input
        list={name+'_list'}
        data-valueid={valueid}

        id={name+"_inputbox"}
        name={name+"_inputbox"}
        value={inputboxValue}
        
        onFocus={handleFocus}
        
        onInput={handleOnInput}
        onChange={(e) => {setInputboxValue(e.target.value)}}

        className={`input-field form-input ${errors.length ? 'error' : ''}`}        
      />
        <datalist id={name+'_list'} >
            {options.map((option, keyId) => {
              return  <option key={keyId} data-valueid={option.id} value={option.name}></option>
            })}
        </datalist>
    
      {errors && <div className="form-error">{errors}</div>}
    </>
  );
};
