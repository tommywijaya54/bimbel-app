import React, { useState } from 'react';

export default ({ label, name, className, errors = [], options, Field, ...props }) => {
  const handleOnInput = (e) => {
    const val = e.target.value.replace(/\D/g, '');
    e.target.value = val.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }

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

        {...props}
        onInput={handleOnInput}
        className={`input-field form-input ${errors.length ? 'error' : ''}`}        
      />
      {errors && <div className="form-error">{errors}</div>}
    </div>
  );
};
