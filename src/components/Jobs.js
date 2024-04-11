import React, { useState, useEffect } from "react";

const JobList = () => {
  const [jobPosts, setJobPosts] = useState([]);

  useEffect(() => {
    const fetchJobDetails = async () => {
      const response = await fetch(
        "http://plugindev.test/wp-json/wp/v2/abcelebiz-jobs/"
      );
      const data = await response.json();
      console.log(data); // Check the full structure in the console
      setJobPosts(data);
    };

    fetchJobDetails();
  }, []);

  if (jobPosts.length === 0) return <div>Loading...</div>;

  return (
    <div className="job-list">
      {jobPosts.map((post) => (
        <div key={post.id} className="job-details">
          <h1 dangerouslySetInnerHTML={{ __html: post.title.rendered }} />
          {/* <div dangerouslySetInnerHTML={{ __html: post.content.rendered }} /> */}
          <div>
            <strong>Company Name:</strong> {post._abcelebiz_company_name}
          </div>
          <div>
            <strong>Deadline:</strong>{" "}
            {post._abcelebiz_deadline || "Not specified"}
          </div>
          <div>
            <strong>Job Type:</strong>{" "}
            {post._abcelebiz_job_type || "Not specified"}
          </div>
          <div>
            <strong>Salary Range:</strong>{" "}
            {post._abcelebiz_salary_range || "Not specified"}
          </div>
          <div>
            <strong>Experience Required:</strong>{" "}
            {post._abcelebiz_experience || "Not specified"}
          </div>
          <div>
            <strong>Job Timing:</strong>{" "}
            {post._abcelebiz_job_time || "Not specified"}
          </div>
          <div>
            <strong>Job Location:</strong>{" "}
            {post._abcelebiz_job_location || "Not specified"}
          </div>
          <div>
            <strong>Job Level:</strong>{" "}
            {post._abcelebiz_job_level || "Not specified"}
          </div>
          <div>
            <strong>Qualifications:</strong>{" "}
            {post._abcelebiz_qualification || "Not specified"}
          </div>
          <div>
            <strong>Vacancies:</strong>{" "}
            {post._abcelebiz_vacancy || "Not specified"}
          </div>
          <div>
            <strong>Short Description:</strong>{" "}
            {post._abcelebiz_short_description || "Not specified"}
          </div>
          <div>
            <strong>Working Hours:</strong>{" "}
            {post._abcelebiz_working_hours || "Not specified"}
          </div>
          <div>
            <strong>Working Days:</strong>{" "}
            {post._abcelebiz_working_days || "Not specified"}
          </div>
          <div>
            <strong>Skills Required:</strong>{" "}
            {post._abcelebiz_skills_required || "Not specified"}
          </div>
          <div>
            <strong>Founded In:</strong>{" "}
            {post._abcelebiz_founded_in || "Not specified"}
          </div>
          <div>
            <strong>Career Page URL:</strong>{" "}
            <a
              href={post._abcelebiz_career_page_url}
              target="_blank"
              rel="noopener noreferrer"
            >
              {post._abcelebiz_career_page_url}
            </a>
          </div>
          {/* Assuming apply_link is a URL for applying to the job */}
          <div>
            <strong>Apply Link:</strong>{" "}
            <a
              href={post._abcelebiz_apply_link}
              target="_blank"
              rel="noopener noreferrer"
            >
              {post._abcelebiz_apply_text || "Apply Here"}
            </a>
          </div>
        </div>
      ))}
    </div>
  );
};

export default JobList;
