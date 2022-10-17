import React, { useEffect, useRef } from 'react';

export default ({ label, name, className, errors = [], Field, ...props }) => {
  const handleKeyDown = (e) => {
    e.target.style.height = 'inherit';
    e.target.style.height = `${e.target.scrollHeight}px`;
  }
  
  const textAreaRef = useRef();

  useEffect(() => {
    if (textAreaRef) {
      // We need to reset the height momentarily to get the correct scrollHeight for the textarea
      textAreaRef.current.style.height = "0px";
      const scrollHeight = textAreaRef.current.scrollHeight;

      // We then set the height directly, outside of the render loop
      // Trying to set this with state or a ref will product an incorrect value.
      textAreaRef.current.style.height = scrollHeight + "px";
    }
  }, [textAreaRef]);

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
        rows="1"
        onKeyDown={handleKeyDown} 
        ref={textAreaRef}
        className={`input-field form-input ${errors.length ? 'error' : ''}`}
      >
      </textarea>
      {errors && <div className="form-error">{errors}</div>}
    </div>
  );
};
