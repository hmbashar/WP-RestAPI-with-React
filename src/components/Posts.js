import React, { useEffect, useState } from 'react';

function WordPressPosts() {
  const [posts, setPosts] = useState([]);

  useEffect(() => {
    fetch('http://plugindev.test/wp-json/wp/v2/posts')
      .then(response => response.json())
      .then(data => {
        setPosts(data);
      })
      .catch(error => console.error('Error fetching posts:', error));
  }, []);

  return (
    <div>
      {posts.map(post => (
        <div key={post.id}>
            {console.log(post)}
          <h2 dangerouslySetInnerHTML={{ __html: post.title.rendered }} />
          <div dangerouslySetInnerHTML={{ __html: post.content.rendered }} />
        </div>
      ))}
    </div>
  );
}

export default WordPressPosts;