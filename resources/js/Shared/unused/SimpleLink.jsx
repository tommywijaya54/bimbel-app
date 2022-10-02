import React from 'react';
import { Link } from '@inertiajs/inertia-react';
import Icon from './Icon';

export default ({type,id,href,children}) => {
    let newhref = href.replace('{id}',id);

    let classNames = 'link inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';

    if(type == 'user'){
        classNames += " user";
    }

    if(type == 'goto'){
        classNames += " goto";
    }


    return (<Link
            href={newhref}
            className={classNames}
        >
            {children}
            {type == 'goto' && <Icon
                                name="cheveron-right"
                                className="block w-6 h-6 text-gray-400 fill-current"
                            />}
        </Link>)
}

