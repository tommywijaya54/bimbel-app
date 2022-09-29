import React from 'react';
export default ({ label, name, className, errors = [], ...props }) => {
  return (
    <div className={className}>
      {label && (
        <label className="form-label" htmlFor={name}>
          {label}:
        </label>
      )}
      <textarea
        id={name}
        name={name}
        {...props}
        rows="4"
        className={`input-field form-input ${errors.length ? 'error' : ''}`}
      >
      </textarea>
      {errors && <div className="form-error">{errors}</div>}
    </div>
  );
};
