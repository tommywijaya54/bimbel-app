import React from 'react';
import cx from 'classnames';
import Icon from "@/Shared/Icon"

export const UpdateButton = ({onClick}) => {
    return <button type="button" className='action-button edit-button' onClick={onClick}>
        Update 
    </button>
}

export const DeleteButton = ({onClick, text = '', className = '', iconClassName = ''}) => {
    if(text){
      return <button type="button" className={'action-button delete-button br-1 btn-white '+className} onClick={onClick}>
        <Icon name="trash" className={'inline-block w-5 h-5 fill-current text-gray-500 ' + iconClassName}></Icon> {text}
      </button>
    }

    return <button type="button" className='action-button delete-button' onClick={onClick}>
        <Icon name="trash" className="block w-5 h-5 text-sky-500 fill-current"></Icon>
    </button>
}


export const GoToButton = ({href}) => {
    <a 
        href={href} 
        className="link goto link inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
            <Icon
                name="cheveron-right"
                className="block w-6 h-6 text-gray-400 fill-current"
            />
    </a>
}

export const LoadingButton = ({ loading, className, children, ...props }) => {
  const classNames = cx(
    'flex items-center',
    'focus:outline-none',
    {
      'pointer-events-none bg-opacity-75 select-none': loading
    },
    className
  );
  return (
    <button disabled={loading} className={classNames} {...props}>
      {loading && <div className="mr-2 btn-spinner" />}
      {children}
    </button>
  );
}
