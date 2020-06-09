const state = {
    user: null,
    userStatus: null,
    posts: null,
    postsStatus: null,
};

const getters = {
    user: state => {
        return state.user;
    },
    posts: state => {
        return state.posts;
    },
    status: state => {
        return {
            user: state.userStatus,
            posts: state.postsStatus,
        };
    },
    friendship: state => {
        return state.user.data.attributes.friendship;
    },
    friendButtonText: (state, getters, rootState) => {
        if (rootState.User.user.data.id === state.user.data.user_id) {
            console.log('Own Profile - rootState: ' + rootState.User.user.data.id + ' state: ' + state.user.data.user_id);
            return '';
        } else if (getters.friendship === null) {
            console.log('Friendship is null')
            return 'Add Friend';
        } else if (getters.friendship.data.attributes.confirmed_at === null
            && getters.friendship.data.attributes.user_id === rootState.User.user.data.id) {
            console.log('Friendship is pending')
            return 'Pending Friend Request';
        } else if (getters.friendship.data.attributes.confirmed_at !== null) {
            console.log('Friendship is confirmed')
            return '';
        }

        return 'Accept';
    }
};

const actions = {
    fetchUser({commit, dispatch}, userId) {
        commit('setUserStatus', 'loading');

        axios.get('/api/users/' + userId)
            .then(response => {
                commit('setUser', response.data);
                commit('setUserStatus', 'success');
            })
            .catch(error => {
                console.log(error);
                commit('setUserStatus', 'error');
            });
    },

    fetchUserPosts({commit, dispatch}, userId) {
        commit('setPostsStatus', 'loading');

        axios.get('/api/users/' + userId + '/posts')
            .then(res => {
                commit('setPosts', res.data);
                commit('setPostsStatus', 'success');
            })
            .catch(error => {
                commit('setPostsStatus', 'error');
            });
    },

    sendFriendRequest({commit, getters}, friendId) {
        if (getters.friendButtonText !== 'Add Friend') {
            return;
        }

        axios.post('/api/friend-request', {'friend_id': friendId})
            .then(res => {
                commit('setUserFriendship', res.data);
            })
            .catch(error => {
            })
    },

    acceptFriendRequest({commit, state}, userId) {
        axios.post('/api/friend-request-response', {'user_id': userId, 'status': 1})
            .then(res => {
                commit('setUserFriendship', res.data);
            })
            .catch(error => {
            })
    },

    ignoreFriendRequest({commit, state}, userId) {
        axios.delete('/api/friend-request-response/delete', {data: {'user_id': userId}})
            .then(res => {
                commit('setUserFriendship', null);
            })
            .catch(error => {
            })
    },

};

const mutations = {
    setUser(state, user) {
        state.user = user;
    },
    setPosts(state, posts) {
        state.posts = posts;
    },
    setUserStatus(state, status) {
        state.userStatus = status;
    },
    setPostsStatus(state, status) {
        state.postsStatus = status;
    },
    setUserFriendship(state, friendship) {
        state.user.data.attributes.friendship = friendship;
    }
};

export default {
    state, getters, actions, mutations,
}
