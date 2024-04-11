import React from "react";
import Settings from "./components/settings";
import Widgets from "./components/widgets";
import WordPressPosts from "./components/Posts";
import JobList from "./components/Jobs";

function App() {
    return (
       <React.Fragment>
          <Widgets />
          <JobList />
          {/* <WordPressPosts /> */}
       </React.Fragment>
    );
}

export default App;