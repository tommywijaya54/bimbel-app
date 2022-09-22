import React from 'react';
import { Link, usePage } from '@inertiajs/inertia-react';

export default function NavigationList() {
    const permissions = usePage().props.auth.permissions;
    
    // const list = 
    const NavList = ({list}) => {
        return list.map((l,i) => {
            if(l.includes("list")){
                const href = l.split("list-")[1];
                return <Link
                        key={i}
                        href={href}
                        className = 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out'
                        >
                        {href.cap()}
                    </Link>
            }
            return null;
        })
    }


    return <>
        <NavList list={permissions}></NavList>
    </>;

    /*


        {permissions.includes('create-users') && 
            <Link
                href='user'
                className = 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out'
                >
                Navigation List - User
            </Link>
        }

    return (
        <Link
            href={href}
            className={
                active
                    ? 'inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
                    : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out'
            }
        >
            {children}
        </Link>
    );
    */
}
