import { InertiaLink } from "@inertiajs/inertia-react"
import Icon from "./Icon"

export default ({obj}) => {
    return <>

        <InertiaLink
            tabIndex="-1"
            href={route('user.show', obj.id)}
            className="user link"
        >
            {obj.name}
        </InertiaLink>
    
    </>
}