import React, {Fragment,useContext} from 'react';
import ListGroups from "./ListGroups";
import {GroupContext} from "./GroupContext";
import ContentLoader from 'react-content-loader'

const Groups = () => {

    const [groups,,loadingGroups] = useContext(GroupContext);

    const Loader = (props) => (
        <ContentLoader speed={2}
                       width={400}
                       height={150}
                       viewBox="0 0 400 150"
                       backgroundColor="#f3f3f3"
                       foregroundColor="#ecebeb"
                       {...props}>

            <circle cx="10" cy="20" r="8" />
            <rect x="25" y="15" rx="5" ry="5" width="220" height="10" />
            <circle cx="10" cy="50" r="8" />
            <rect x="25" y="45" rx="5" ry="5" width="220" height="10" />
            <circle cx="10" cy="80" r="8" />
            <rect x="25" y="75" rx="5" ry="5" width="220" height="10" />
            <circle cx="10" cy="110" r="8" />
            <rect x="26" y="105" rx="5" ry="5" width="220" height="10" />
            <rect x="28" y="127" rx="5" ry="5" width="220" height="10" />
            <circle cx="9" cy="132" r="8" />
        </ContentLoader>)
    return (
        <Fragment>
            <div className="py-3 w-1/4">
                {loadingGroups? <Loader/>: <ListGroups groups={groups}/>}
            </div>
        </Fragment>
    );

}

export default Groups;
