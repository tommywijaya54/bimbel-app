import React from 'react';

export default ({
  label,
  name,
  className,
  children,
  errors = [],
  Field,
  ...props
}) => {
  return (
    <div className={className}>
      {label && (
        <label className="form-label" htmlFor={name}>
          {label}:
        </label>
      )}
      <select
        id={name}
        name={name}
        {...props}
        className={`input-field form-select ${errors.length ? 'error' : ''}`}
      >
        {children}
      </select>
      {errors && <div className="form-error">{errors}</div>}
    </div>
  );
};
