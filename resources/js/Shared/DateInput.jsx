import React from 'react';

export default ({ label, name, className, errors = [], ...props }) => {
  return (
    <div className={className}>
      {label && (
        <label className="form-label" htmlFor={name}>
          {label}:
        </label>
      )}
      <input
        type='date'
        id={name}
        name={name}
        {...props}
        className={`input-field form-input ${errors.length ? 'error' : ''}`}
      />
      {errors && <div className="form-error">{errors}</div>}
    </div>
  );
};
