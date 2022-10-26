import React from 'react';

export default ({name, errors = [], required, Field, ...props }) => {
  return (
    <>
      <input
        id={name}
        name={name}
        {...props}
        required={required}
        className={`input-field form-input ${errors.length ? 'error' : ''}`}
      />
      {errors && <div className="form-error">{errors}</div>}
    </>
  );
};
