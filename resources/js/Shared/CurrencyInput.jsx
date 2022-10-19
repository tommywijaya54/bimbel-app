import React, { useEffect, useState } from 'react';

export default ({ label, name, className, errors = [], options,required, Field, type, value, ...props }) => {
  const reformatToCurrency = (value) => {
    let numberValue = typeof value === 'string' ?  value.replace(/\D/g, '') : value;
    return new String(numberValue).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }
  
  const handleOnInput = (e) => {
    e.target.value = reformatToCurrency(e.target.value);
  }
  
  value = reformatToCurrency(value);

  useEffect(() => {
    value = reformatToCurrency(value);
  },[value])

  return (
    <div className={className + ' currency-input-field'}>
      {label && (
        <label className="form-label" htmlFor={name}>
          {label}:
        </label>
      )}
      <span className='sign'>{locale.currency.sign}</span>
      <input
        id={name}
        name={name}
        required={required}
        type='text'
        value={value}
        {...props}
        onInput={handleOnInput}
        className={`input-field form-input ${errors.length ? 'error' : ''}`}        
      />
      {errors && <div className="form-error">{errors}</div>}
    </div>
  );
};
