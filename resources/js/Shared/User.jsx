import { InertiaLink } from "@inertiajs/inertia-react"
import Icon from "./Icon"

export default ({user}) => {
    console.log(user);
    
    return <>
        <InertiaLink
            tabIndex="-1"
            // href={route('user.show', user.id)}
            className="user link"
        >
            {user.name}
        </InertiaLink>
    </>
}