import React from 'react';

export default ({ label, name, className, errors = [], required, Field, ...props }) => {
  return (
    <div className={className}>
      {label && (
        <label className="form-label" htmlFor={name}>
          {label}:
        </label>
      )}
      <input
        id={name}
        name={name}
        {...props}
        required={required}
        className={`input-field form-input ${errors.length ? 'error' : ''}`}
      />
      {errors && <div className="form-error">{errors}</div>}
    </div>
  );
};
